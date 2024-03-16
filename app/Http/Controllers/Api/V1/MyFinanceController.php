<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\V1\StoreMyFinanceRequest;
use App\Http\Requests\V1\UpdateMyFinanceRequest;

use App\Models\MyFinance;
use App\Models\Transaction;
use App\Models\Currency;
use App\Http\Resources\V1\MyFinanceResource;
use App\Http\Resources\V1\MyFinanceCollection;
use App\Http\Resources\V1\TransactionResource;
use App\Http\Resources\V1\TransactionCollection;
use App\Http\Resources\V1\CurrencyResource;
use App\Http\Resources\V1\CurrencyCollection;
use Carbon\Carbon;

class MyFinanceController extends Controller
{
    /**
     * Display the financial summary including charts and transaction details.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing financial summary data.
     */
    public function show()
    {
        // Retrieve the authenticated user's ID
        $user = auth()->user();

        // Retrieve filters from the request
        $isIncomeFilter = request('isIncome', null);
        $periodFilter = request('period', null);

        // Retrieve financial data for the user
        $myfinance = MyFinance::where('userID', $user->id)
                        ->with('currency')
                        ->get();
        $transactions = Transaction::where('userID', $user->id)
                        ->with('category')
                        ->get();

        // Bar Chart: Calculate total income and expenses for the specified period
        if ($periodFilter === 'this_week') {
            // Count total expense and income of each day of the current week
            $currentWeekStart = now()->startOfWeek();
            $currentWeekEnd = now()->endOfWeek();

            $totals = $transactions
                ->whereBetween('date', [$currentWeekStart, $currentWeekEnd])
                ->groupBy(function ($transaction) {
                    return Carbon::parse($transaction->date)->toDateString();
                })
                ->map(function ($dayTransactions) {
                    return [
                        'total_income' => (float) $dayTransactions->where('isIncome', true)->sum('amount'),
                        'total_expense' => (float) $dayTransactions->where('isIncome', false)->sum('amount'),
                    ];
                });
        } elseif ($periodFilter === 'this_month' || $periodFilter === 'last_month') {
            // Count total expense and income of each week of the month
            $monthStart = now()->startOfMonth();
            $monthEnd = now()->endOfMonth();

            if ($periodFilter === 'last_month') {
                $monthStart->subMonth();
                $monthEnd->subMonth();
            }

            $totals = $transactions
                ->whereBetween('date', [$monthStart, $monthEnd])
                ->groupBy(function ($transaction) {
                    return 'Week ' . Carbon::parse($transaction->date)->weekOfMonth;
                })
                ->map(function ($weekTransactions) {
                    return [
                        'total_income' => (float) $weekTransactions->where('isIncome', true)->sum('amount'),
                        'total_expense' => (float) $weekTransactions->where('isIncome', false)->sum('amount'),
                    ];
                });
        } else {
            $subMonths = ($periodFilter === 'last_3_months') ? 2 : 4;

            // Calculate the start and end dates for the specified period
            $startOfMonth = now()->subMonths($subMonths)->startOfMonth();
            $endOfMonth = now()->addMonth()->endOfMonth();

            $totals = $transactions
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->groupBy(function ($transaction) {
                    return Carbon::parse($transaction->date)->format('Y-m');
                })
                ->map(function ($monthTransactions) {
                    return [
                        'total_income' => (float) $monthTransactions->where('isIncome', true)->sum('amount'),
                        'total_expense' => (float) $monthTransactions->where('isIncome', false)->sum('amount'),
                    ];
                });
        }

        // Calculate filtered expenses and income based on the bar chart data
        $filteredExpenses = (float) $totals->sum('total_expense');
        $filteredIncome = (float) $totals->sum('total_income');

        // Calculate total expenses and income for all transactions
        $totalExpenses = (float) $transactions->where('isIncome', 0)->sum('amount');
        $totalIncome = (float) $transactions->where('isIncome', 1)->sum('amount');

        // Apply isIncome filter if provided
        if ($isIncomeFilter !== null) {
            $transactions = $transactions->where('isIncome', $isIncomeFilter);
        }

        // Donut Chart: Get top transactions grouped by category
        $topTransactions = collect($transactions)->groupBy('categoryID')->map(function ($group) {
            return [
                'category' => $group[0]->category,
                'amount' => (float) $group->sum('amount')
            ];
        })->sortByDesc('amount')->values()->all();

        // All Transactions: Group transactions by date
        $groupedTransactions = collect($transactions)->groupBy(function ($transaction) {
            return Carbon::parse($transaction->date)->startOfDay()->format('Y-m-d');
        });

        // Get today's and yesterday's transactions
        $today = Carbon::today()->format('Y-m-d');
        $yesterday = Carbon::yesterday()->format('Y-m-d');

        $allTransactions = [
            'today' => collect($groupedTransactions->get($today, []))
                ->sortByDesc('date')
                ->take(2)
                ->values()
                ->all(),
            'yesterday' => collect($groupedTransactions->get($yesterday, []))
                ->sortByDesc('date')
                ->take(2)
                ->values()
                ->all(),
        ];

        // Return JSON response containing financial summary data
        return response()->json([
            'success' => 'true',
            'data' => [
                'finance' => $myfinance,
                'totals' => $totals,
                'filtered_expenses' => $filteredExpenses,
                'filtered_incomes' => $filteredIncome,
                'total_expenses' => $totalExpenses,
                'total_incomes' => $totalIncome,
                'top_transactions' => $topTransactions,
                'all_transactions' => $allTransactions
            ],
        ]);
    }

    
    /**
     * Display all available currencies.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing data of all available currencies.
     */
    public function show_currency()
    {
        // Retrieve all currencies
        $currencies = Currency::all();

        // Return JSON response containing data of all available currencies
        return response()->json(['success'=> 'true', 'data' => CurrencyResource::collection($currencies)]);
    }


    /**
     * Create a new financial record.
     *
     * @param \App\Http\Requests\StoreMyFinanceRequest $request The incoming request containing data for creating a new financial record.
     * @return \Illuminate\Http\JsonResponse JSON response indicating success or failure of the operation, along with the created financial record.
     */
    public function create(StoreMyFinanceRequest $request)
    {
        // Retrieve the user ID from the JWT token
        $user = auth()->user();

        // Add the user ID to the request data
        $request->merge(['userID' => $user->id]);

        // Create a new financial record using the request data and return JSON response
        return response()->json(['success' => 'true', 'data' => new MyFinanceResource(MyFinance::create($request->all()))]);
    }

    /**
     * Update the user net worth while counting the update as a transaction
     *
     * @param \App\Http\Requests\UpdateMyFinanceRequest $request The incoming request containing data for updating the financial record.
     * @param \App\Models\MyFinance $myfinance The financial record to update.
     * @return \Illuminate\Http\JsonResponse JSON response indicating success or failure of the operation, along with the updated financial record.
     */
    public function update(UpdateMyFinanceRequest $request, MyFinance $myfinance)
    {
        // Validate the request data
        $user = auth()->user();
        $data = $request->validated();

        try {
            // Retrieve the old balance before the update
            $oldBalance = $myfinance->where('userID', $user->id)->value('totalbalance');

            // Update the totalbalance in MyFinance
            $myfinance->where('userID', $user->id)->update(['totalbalance' => $data['totalbalance']]);

            // Fetch updated MyFinance data
            $updatedMyFinance = MyFinance::where('userID', $user->id)
                ->with('currency')
                ->first();

        } catch (Exception $e) {
            return response()->json(['success'=> 'false', 'message' => 'Failed to update Net Worth'], 500);
        }

        // Calculate the difference between the old and new balance
        $balanceDifference = $data['totalbalance'] - $oldBalance;
        // Determine whether it is income or expense
        $isIncome = ($balanceDifference >= 0) ? 1 : 0;

        // Add Transaction
        $transaction = new Transaction([
            'userID' => $user->id,
            'categoryID' => 1,
            'isIncome' => $isIncome,
            'amount' => abs($balanceDifference),
            'hasContributed' => 0,
            'date' => Carbon::now(),
            'note' => "Balance Update",
        ]);
        $transaction->save();

        // Return JSON response indicating success and the updated financial record
        return response()->json(['success'=> 'true', 'message' => 'Net Worth updated successfully', 'data' => $updatedMyFinance]);
    }

    /**
     * Remove the specified financial record from storage.
     *
     * @param string $id The ID of the financial record to delete.
     * @return \Illuminate\Http\JsonResponse JSON response indicating success or failure of the operation.
     */
    public function destroy(string $id)
    {
        // Find the financial record by its ID
        $myFinance = MyFinance::find($id);

        // Check if the financial record exists
        if (!$myFinance) {
            return response()->json(['success'=> 'false', 'message' => 'Financial record not found'], 404);
        }

        // Attempt to delete the financial record
        try {
            $myFinance->delete();
        } catch (Exception $e) {
            return response()->json(['success'=> 'false', 'message' => 'Failed to delete financial record'], 500);
        }

        // Return JSON response indicating success
        return response()->json(['success'=> 'true', 'message' => 'Financial record deleted successfully']);
    }
}
