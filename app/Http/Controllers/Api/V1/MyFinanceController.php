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
     * Display the specified resource.
     */
    public function show()
    {
        // get user id
        $user = auth()->user();

        // Retrieve filters from the request
        $isIncomeFilter = request('isIncome', null);
        $periodFilter = request('period', null);

        $myfinance = MyFinance::where('userID', $user->id)
            ->with('currency')
            ->get();
        $transactions = Transaction::where('userID', $user->id)
            ->with('category')
            ->get();

        ////////Bar Chart
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

        ////////Filtered expenses and income based on bar chart
        $filteredExpenses = (float) $totals->sum('total_expense');
        $filteredIncome = (float) $totals->sum('total_income');

        ////////Count all expenses and income
        $totalExpenses = (float) $transactions->where('isIncome', 0)->sum('amount');
        $totalIncome = (float) $transactions->where('isIncome', 1)->sum('amount');

        // Apply isIncome filter if provided
        if ($isIncomeFilter !== null) {
            $transactions = $transactions->where('isIncome', $isIncomeFilter);
        }

        ////////Donut Chart
        $topTransactions = collect($transactions)->groupBy('categoryID')->map(function ($group) {
            return [
                'category' => $group[0]->category,
                'amount' => (float) $group->sum('amount')
            ];
        })->sortByDesc('amount')->values()->all();

        ///////All Transaction
        $groupedTransactions = collect($transactions)->groupBy(function ($transaction) {
            return Carbon::parse($transaction->date)->startOfDay()->format('Y-m-d');
        });

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
     * Display the specified resource.
     */
    public function show_currency()
    {
        // Retrieve all currencies
        $currencies = Currency::all();

        return response()->json(['success'=> 'true', 'data' => CurrencyResource::collection($currencies)]);
    }

        /**
     * Show the form for creating a new resource.
     */
    public function create(StoreMyFinanceRequest $request)
    {
        # get user id from jwt token
        $user = auth()->user();

        // # add user id to the request
        $request->merge(['userID' => $user->id]);

        return response()->json(['success' => 'true', 'data' => new MyFinanceResource(MyFinance::create($request->all()))]);
    }

    /**
     * Update the specified resource in storage.
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

        # Add Transacion
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

        return response()->json(['success'=> 'true', 'message' => 'Net Worth updated successfully', 'data' => $updatedMyFinance]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
