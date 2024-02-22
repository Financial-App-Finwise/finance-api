<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreBudgetPlanRequest;
use App\Http\Requests\V1\UpdateBudgetPlanRequest;

use App\Models\BudgetPlan;
use App\Http\Resources\V1\BudgetPlanResource;
use App\Http\Resources\V1\BudgetPlanCollection;
use Carbon\Carbon;


class BudgetPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $year, string $month)
    {
        // get user id
        $user = auth()->user();
    
        // retrieve budget plans for a specific year and month, and group by month
        $budgetPlans = BudgetPlan::where('userID', $user->id)
                        ->whereYear('created_at', $year)
                        ->whereMonth('created_at', $month)
                        ->orderBy('created_at', 'asc')
                        ->get();
        
        $totalBudgetPlans = $budgetPlans->count();
    
        return response()->json(['success' => 'true', 'total' => $totalBudgetPlans, 'data' => $budgetPlans]);
    }
    
    
    private function getMonthName($monthNumber)
    {
        return date("F", mktime(0, 0, 0, $monthNumber, 1));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $budgetplan = BudgetPlan::find($id);
        return response()->json($budgetplan);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBudgetPlanRequest $request)
    {
        // Logic to create a new budget plan
        # get user id from jwt token
        $user = auth()->user();
        # add user id to the request
        $request->merge(['userID' => $user->id]);

        return response()->json(['success'=> 'true', 'message' => 'Budget Plan created successfully', 'data' => new BudgetPlanResource(BudgetPlan::create($request->all()))]);
    }

    /**
     * Display the specified resource.
     */
    public function show(BudgetPlan $budgetplan)
    {
        // Logic to get a specific budget plan by ID
        return response()->json(['success' => 'true', 'data' => $budgetplan]);
    }
        /**
     * Display the specified resource.
     */
    public function show_summary(string $year)
    {
        // get user id
        $user = auth()->user();
    
        // retrieve budget plans for a specific year and group by month
        $budgetPlans = BudgetPlan::where('userID', $user->id)
                        ->whereYear('created_at', $year)
                        ->orderBy('created_at', 'asc')
                        ->get()
                        ->groupBy(function($date) {
                            return Carbon::parse($date->created_at)->format('m');
                        });
    
        $formattedData = [];
    
        // Loop through all months (1 to 12) and set count to 0 if no items found
        for ($month = 1; $month <= 12; $month++) {
            $key = str_pad($month, 2, '0', STR_PAD_LEFT); // Format month with leading zero
            $formattedData[$this->getMonthName($key)] = isset($budgetPlans[$key]) ? count($budgetPlans[$key]) : 0;
        }
    
        return response()->json(['success' => 'true', 'data' => $formattedData]);
    }    
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BudgetPlan $budgetPlan)
    {
        // Logic to show the form for editing a budget plan
        // Similar to the 'create' method, you can return a view or a response
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBudgetPlanRequest $request, BudgetPlan $budgetplan)
    {
        // Check if the model is retrieved successfully
        if (!$budgetplan) {
            return response()->json(['success'=> 'false', 'message' => 'Budget Plan not found'], 404);
        }
    
        # add user id to the request
        $user = auth()->user();
        # check if the budget plan belongs to the user
        if ($budgetplan->userID != $user->id) {
            return response()->json(['success'=> 'false', 'message' => 'You are not authorized to update this budget plan'], 403);
        }
        
        // Logic to update a budget plan by ID
        try {
            $budgetplan->update($request->validated());
        } catch (Exception $e) {
            return response()->json(['success'=> 'false', 'message' => 'Failed to update Budget Plan'], 500);
        }
    
        return response()->json([
            'success' => 'true',
            'message' => 'Budget Plan updated successfully',
            'data' => $budgetplan->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BudgetPlan $budgetplan)
    {
        # check if the budget plan belongs to the user
        $user = auth()->user();
        if ($budgetplan->userID != $user->id) {
            return response()->json(['success'=> 'false', 'message' => 'You are not authorized to delete this budget plan'], 403);
        }

        // Logic to delete a budget plan by ID
        $budgetplan->delete();

        return response()->json(['success'=> 'true', 'message' => 'Budget Plan deleted successfully']);
    }
}
