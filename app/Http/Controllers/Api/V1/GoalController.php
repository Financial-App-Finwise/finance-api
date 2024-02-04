<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreGoalRequest;
use App\Http\Requests\V1\UpdateGoalRequest;

use App\Models\Goal;
use App\Http\Resources\V1\GoalResource;
use App\Http\Resources\V1\GoalCollection;

use App\Filters\V1\GoalFilter;


class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $filter = new GoalFilter();
        $queryItems = $filter->transform($request); //[['column', 'operator', 'value']]
        
        if (count($queryItems) == 0){
            return new GoalCollection(Goal::paginate());
        } else{ 

            $goal = Goal::where($queryItems)->paginate();

            return new GoalCollection($goal->appends($request->query()));

            //return new CategoryCollection(Category::where($queryItems)->paginate());
        }
    }
    // public function index(){
    //     // Logic to get all goals
    //     //return Goal::all(); 

    //     //Logic to store data in collection
    //     //return new GoalCollection(Goal::all());

    //     //Logic to paginate the store data 
    //     return new GoalCollection(Goal::paginate());

    // }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Logic to get a specific user by ID
         $goal = Goal::find($id);
         return response()->json($goal);
        //return $goal = Goal::find($id);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGoalRequest $request)
    {
        // Logic to create a new user
        return new GoalResource(Goal::create($request->all()));
        //return response()->json(['message' => 'Goal created successfully']);
    }
    /**
     * Display the specified resource.
     */
    public function show(Goal $goal)
    {
        // Logic to get a specific goal by ID
        return response()->json($goal);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Goal $goal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGoalRequest $request, Goal $goal)
    {
        // Logic to update a goal by ID
        $goal->update($request->all());
        return response()->json(['message' => 'Goal updated successfully']);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Goal $goal)
    {
        // Check if the authenticated user is the owner of the goal
        if ($user->id !== $goal->userID) {
            return response()->json(['error' => 'Unauthorized'], 403);
            }
            // Logic to delete a goal by ID
            $goal->delete();
        // Logic to delete a goal by ID
        return response()->json(['message' => 'Goal deleted successfully']);
    }
}
