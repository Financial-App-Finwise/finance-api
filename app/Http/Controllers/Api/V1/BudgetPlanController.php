<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreBudgetPlanRequest;
use App\Http\Requests\V1\UpdateBudgetPlanRequest;
use App\Models\BudgetPlan;
use App\Models\Transaction;
use App\Http\Resources\V1\BudgetPlanResource;
use App\Http\Resources\V1\BudgetPlanCollection;
use Carbon\Carbon;


class BudgetPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param string $year The year for filtering budget plans.
     * @param string $month The month for filtering budget plans.
     * @return \Illuminate\Http\JsonResponse JSON response containing budget-related data.
     */
    public function index(string $year, string $month)
    {
        // Get the currently authenticated user
        $user = auth()->user();

        // Query to retrieve budget plans with associated transactions for the given year and month
        $budgetPlansQuery = BudgetPlan::with('transactions')
            ->where('userID', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month);

        // Check if monthly filter is applied
        $isMonthlyFilter = request('is_monthly', null);

        // Apply monthly filter if specified
        if ($isMonthlyFilter !== null) {
            $budgetPlansQuery->where('isMonthly', $isMonthlyFilter);
        }

        // Retrieve budget plans based on the query and order them by date
        $budgetPlans = $budgetPlansQuery->orderBy('date', 'asc')->get();

        // Calculate total number of budget plans and planned budgets
        $totalBudgetPlans = $budgetPlans->count();
        $plannedBudgets = (float) $budgetPlans->sum('amount');

        // Add additional information such as transaction count, spent amount, and remaining amount
        $budgetPlansWithCount = $budgetPlans->map(function ($budgetPlan) {
            $budgetPlan['transactions_count'] = (int) $budgetPlan->transactions->count();
            $budgetPlan['spent'] = (float) $budgetPlan->transactions->sum('amount');
            $budgetPlan['remaining_amount'] = (float) ($budgetPlan->amount - $budgetPlan['spent']);
            return $budgetPlan;
        });

        // Calculate total amount spent by the user on transactions linked to budget plans
        $spent = (float) Transaction::where('userID', $user->id)
            ->whereNotNull('budgetplanID')
            ->sum('amount');

        // Calculate available budget, over-budget amount, and remaining budget
        $available = (float) ($plannedBudgets - $spent);
        $overBudget = (float) (($spent > $plannedBudgets) ? $spent - $plannedBudgets : 0);

        // Construct JSON response with budget-related data
        return response()->json([
            'success' => 'true',
            'data' => [
                'total_budgets' => $totalBudgetPlans,
                'available' => $available,
                'spent' => $spent,
                'planned_budgets' => $plannedBudgets,
                'over_budget' => $overBudget,
                'budget_plans' => $budgetPlansWithCount
            ],
        ]);
    }
       
    private function getMonthName($monthNumber)
    {
        return date("F", mktime(0, 0, 0, $monthNumber, 1));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreBudgetPlanRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBudgetPlanRequest $request)
    {
        // Retrieve the user ID from the JWT token
        $user = auth()->user();

        // Add the user ID to the request data
        $request->merge(['userID' => $user->id]);

        // Create a new budget plan using the request data and return JSON response
        return response()->json([
            'success' => 'true',
            'message' => 'Budget Plan created successfully',
            'data' => new BudgetPlanResource(BudgetPlan::create($request->all()))
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\BudgetPlan
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(BudgetPlan $budgetplan)
    {
        // Retrieve filter parameter from the request, if provided
        $filter = request('filter', null);

        // Load transactions relationship and apply sorting based on the requested filter
        $transactions = $budgetplan->transactions();

        switch ($filter) {
            case 'recently':
                $transactions = $transactions->orderByDesc('date');
                break;
            case 'earliest':
                $transactions = $transactions->orderBy('date');
                break;
            case 'lowest':
                $transactions = $transactions->orderBy('amount');
                break;
            case 'highest':
                $transactions = $transactions->orderByDesc('amount');
                break;
            // 'all' or unknown filters will include all transactions
            default:
                break;
        }

        // Retrieve the sorted transactions
        $sortedTransactions = $transactions->get();

        // Group transactions with the same date into an array
        $groupedTransactions = $sortedTransactions->groupBy(function ($transaction) {
            // Format the date to only include the date portion
            $formattedDate = \Carbon\Carbon::parse($transaction->date)->toDateString();

            // Determine if it's today, yesterday, or another day
            if ($formattedDate === \Carbon\Carbon::now()->toDateString()) {
                return 'today';
            } elseif ($formattedDate === \Carbon\Carbon::yesterday()->toDateString()) {
                return 'yesterday';
            } else {
                return $formattedDate;
            }
        });

        // Cast "amount" and other money-related values to float
        $budgetplan['amount'] = (float) $budgetplan['amount'];
        $budgetplan['transactions'] = $groupedTransactions;
        $budgetplan['transactions_count'] = (int) $sortedTransactions->count();
        $budgetplan['spent'] = (float) $sortedTransactions->sum('amount');
        $budgetplan['remaining_amount'] = (float) ($budgetplan['amount'] - $budgetplan['spent']);

        // Return JSON response containing the specified budget plan and its transactions
        return response()->json(['success' => 'true', 'data' => $budgetplan]);
    }

    /**
     * Display the summary of budget plans for the specified year.
     *
     * @param string $year The year for which the summary is requested.
     * @return \Illuminate\Http\JsonResponse JSON response containing the summary of budget plans grouped by month.
     */
    public function show_summary(string $year)
    {
        // Get the user ID of the authenticated user
        $user = auth()->user();

        // Retrieve budget plans for the specified year and group them by month
        $budgetPlans = BudgetPlan::where('userID', $user->id)
                        ->whereYear('date', $year)
                        ->orderBy('date', 'asc')
                        ->get()
                        ->groupBy(function($date) {
                            return Carbon::parse($date->date)->format('m');
                        });

        $formattedData = [];

        // Loop through all months (1 to 12) and set count to 0 if no items found
        for ($month = 1; $month <= 12; $month++) {
            $key = str_pad($month, 2, '0', STR_PAD_LEFT); // Format month with leading zero
            $formattedData[$this->getMonthName($key)] = isset($budgetPlans[$key]) ? count($budgetPlans[$key]) : 0;
        }

        // Return JSON response containing the summary of budget plans grouped by month
        return response()->json(['success' => 'true', 'data' => $formattedData]);
    }    

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateBudgetPlanRequest $request The incoming request containing data for updating the budget plan.
     * @param \App\Models\BudgetPlan $budgetplan The budget plan to update.
     * @return \Illuminate\Http\JsonResponse JSON response indicating success or failure of the operation, along with the updated budget plan.
     */
    public function update(UpdateBudgetPlanRequest $request, BudgetPlan $budgetplan)
    {
        // Check if the budget plan is retrieved successfully
        if (!$budgetplan) {
            return response()->json(['success'=> 'false', 'message' => 'Budget Plan not found'], 404);
        }

        // Get the user ID of the authenticated user
        $user = auth()->user();

        // Check if the budget plan belongs to the user
        if ($budgetplan->userID != $user->id) {
            return response()->json(['success'=> 'false', 'message' => 'You are not authorized to update this budget plan'], 403);
        }
        
        // Logic to update a budget plan by ID
        try {
            $budgetplan->update($request->validated());
        } catch (Exception $e) {
            return response()->json(['success'=> 'false', 'message' => 'Failed to update Budget Plan'], 500);
        }

        // Return JSON response indicating success and the updated budget plan
        return response()->json([
            'success' => 'true',
            'message' => 'Budget Plan updated successfully',
            'data' => $budgetplan->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\BudgetPlan $budgetplan The budget plan to delete.
     * @return \Illuminate\Http\JsonResponse JSON response indicating success or failure of the operation.
     */
    public function destroy(BudgetPlan $budgetplan)
    {
        // Check if the budget plan belongs to the user
        $user = auth()->user();
        if ($budgetplan->userID != $user->id) {
            return response()->json(['success'=> 'false', 'message' => 'You are not authorized to delete this budget plan'], 403);
        }

        // Logic to delete a budget plan by ID
        $budgetplan->delete();

        // Return JSON response indicating success
        return response()->json(['success'=> 'true', 'message' => 'Budget Plan deleted successfully']);
    }
}
