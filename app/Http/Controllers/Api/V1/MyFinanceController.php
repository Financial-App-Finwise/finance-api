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
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

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
                        'total_income' => $dayTransactions->where('isIncome', true)->sum('amount'),
                        'total_expense' => $dayTransactions->where('isIncome', false)->sum('amount'),
                    ];
                });
        } elseif ($periodFilter === 'this_month' || $periodFilter === 'last_month') {
            // Count total expense and income of each week of the month (what is the total income and expense of the first week, second week, ...)
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
                        'total_income' => $weekTransactions->where('isIncome', true)->sum('amount'),
                        'total_expense' => $weekTransactions->where('isIncome', false)->sum('amount'),
                    ];
                });
        } elseif ($periodFilter === 'last_3_months') {

        
            // Calculate the start and end dates for the specified period
            $startOfMonth = now()->subMonths(3)->startOfMonth();
            $endOfMonth = now()->endOfMonth()->subMonth();
        
            $totals = $transactions
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->groupBy(function ($transaction) {
                    return Carbon::parse($transaction->date)->format('Y-m');
                })
                ->map(function ($monthTransactions) {
                    return [
                        'total_income' => $monthTransactions->where('isIncome', true)->sum('amount'),
                        'total_expense' => $monthTransactions->where('isIncome', false)->sum('amount'),
                    ];
                });
        }

        ////////Count all expenses and income
        $totalExpenses = $transactions->where('isIncome', 0)->sum('amount');
        $totalIncome = $transactions->where('isIncome', 1)->sum('amount');        

        // Apply isIncome filter if provided
        if ($isIncomeFilter !== null) {
            $transactions = $transactions->where('isIncome', $isIncomeFilter);
        }

        ////////Donut Chart
        $summedTransactions = collect($transactions)->groupBy('note')->map(function ($group) {
            return [
                'note' => $group[0]->note,
                'amount' => $group->sum('amount'),
            ];
        })->sortByDesc('amount')->values()->all();
        
        ///////All Transation 
        $groupedTransactions = collect($transactions)->groupBy(function ($transaction) {
            return Carbon::parse($transaction->date)->startOfDay()->format('Y-m-d');
        });

        $today = Carbon::today()->format('Y-m-d');
        $yesterday = Carbon::yesterday()->format('Y-m-d');

        $organizedTransactions = [
            'today' => $groupedTransactions->get($today, []),
            'yesterday' => $groupedTransactions->get($yesterday, []),
        ];

        return response()->json([
            'success' => 'true',
            'data' => [
                'finance' => MyFinanceResource::collection($myfinance),
                'total_expenses' => $totalExpenses,
                'total_incomes' => $totalIncome,
                'top_transaction' => $summedTransactions,
                'all_transaction' => $organizedTransactions,
                'totals' => $totals
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
     * Store a newly created resource in storage.
     */
    public function store()
    {

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
            $myfinance->where('userID', $user->id)->update(['totalbalance' => $data['totalbalance']]);

            $updatedMyFinance = MyFinance::where('userID', $user->id)
            // ->where('your_column_name', $filter)
            ->with('currency')
            ->get();

        } catch (Exception $e) {
            return response()->json(['success'=> 'false', 'message' => 'Failed to update Net Worth'], 500);
        }

        return response()->json(['success'=> 'true', 'message' => 'Net Worth updated successfully', 'data' => MyFinanceResource::collection($updatedMyFinance)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    
}
