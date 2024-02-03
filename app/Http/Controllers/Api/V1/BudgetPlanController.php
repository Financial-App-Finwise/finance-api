<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreBudgetPlanRequest;
use App\Http\Requests\V1\UpdateBudgetPlanRequest;

use App\Models\BudgetPlan;
use App\Http\Resources\V1\BudgetPlanResource;
use App\Http\Resources\V1\BudgetPlanCollection;

class BudgetPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Logic to paginate the budget plan data
        return new BudgetPlanCollection(BudgetPlan::paginate());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Logic to get a specific budget plan by ID
        // Assuming you want to create a form on the client-side
        // You can return a view or a response as needed
        $budgetplan = BudgetPlan::find($id);
        return response()->json($budgetplan);
    }

    public function showYear($year)
    {
        // Assuming you have a relationship between User and BudgetPlan
        // Adjust the relationship method based on your actual Eloquent setup

        // Retrieve the authenticated user
        $user = auth()->user();

        // Retrieve budget plans for the specified year, sorted by month
        $budgetPlans = $user->budgetPlans()
            ->whereYear('created_at', $year)
            ->orderBy('created_at')
            ->get();

        // Transform the data into the desired nested structure
        $nestedData = [];

        foreach ($budgetPlans as $budgetPlan) {
            $month = $budgetPlan->created_at->format('F'); // Get the month name
            $nestedData[$month][] = $budgetPlan;
        }

        // Return the nested data as JSON response
        return response()->json([$year => $nestedData]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBudgetPlanRequest $request)
    {
        // Logic to create a new budget plan
        return new BudgetPlanResource(BudgetPlan::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(BudgetPlan $budgetplan)
    {
        // Logic to get a specific budget plan by ID
        return response()->json($budgetplan);
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
    public function update(UpdateBudgetPlanRequest $request, BudgetPlan $budgetPlan)
    {
        // Validate the request using the UpdateBudgetPlanRequest class
    
        // Check if the model is retrieved successfully
        if (!$budgetPlan) {
            return response()->json(['error' => 'Budget Plan not found'], 404);
        }
    
        // Logic to update a budget plan by ID
        try {
            $budgetPlan->update($request->validated());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update Budget Plan'], 500);
        }
    
        return response()->json(['message' => 'Budget Plan updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BudgetPlan $budgetPlan)
    {
        // Check if the authenticated user is the owner of the budget plan
        if ($user->id !== $budgetPlan->userID) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Logic to delete a budget plan by ID
        $budgetPlan->delete();

        return response()->json(['message' => 'Budget Plan deleted successfully']);
    }
}
