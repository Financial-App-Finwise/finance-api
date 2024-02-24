<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreGoalRequest;
use App\Http\Requests\V1\UpdateGoalRequest;

use App\Models\User;
use App\Models\Goal;
use App\Http\Resources\V1\GoalResource;
use App\Http\Resources\V1\GoalCollection;

use App\Filters\V1\GoalFilter;
use Carbon\Carbon;


class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function index(Request $request)
    // {
    //     $user = auth()->user();

    //     $goal = Goal::where('userID', $user->id)->get();

    //     $filter = new GoalFilter();
    //     $queryItems = $filter->transform($request); //[['column', 'operator', 'value']]

    //     if (count($queryItems) == 0) {
    //         return new GoalCollection(Goal::paginate());
    //     } else {

    //         $goal = Goal::where($queryItems)->paginate();

    //         return new GoalCollection($goal->appends($request->query()));

    //     }
    // }

    public function index(Request $request)
    {
        $user = auth()->user();

        $filter = new GoalFilter();
        $queryItems = $filter->transform($request); //[['column', 'operator', 'value']]

        $query = Goal::where('userID', $user->id);

        // Apply filters from the query parameters
        foreach ($queryItems as $item) {
            $query->where($item[0], $item[1], $item[2]);
        }

        // Filter by status if provided
        $status = $request->get('status');
        if ($status) {
            if ($status === 'in Progress') {
                $query->where('remainingSave', '>', 0)
                    ->where('currentSave', '<', \DB::raw('amount'));
            } elseif ($status === 'Achieved') {
                $query->where('remainingSave', '=', 0)
                    ->where('currentSave', '=', \DB::raw('amount'));
            }
        }
        $goals = $query->orderBy('created_at', 'desc')->paginate();
        return new GoalCollection($goals->appends($request->query()));
    }

    /**
     * Show the form for creating a new resource.
     */

    // public function create()
    // {
    //     // Logic to get a specific user by ID
    //     $goal = Goal::find($id);
    //     return response()->json($goal);
    //     //return $goal = Goal::find($id);
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(StoreGoalRequest $request)
    // {
    //     # get user id from jwt token
    //     $user = auth()->user();
    //     # add user id to the request
    //     $request->merge(['userID' => $user->id]);
    //     // Logic to create a new smart goal
    //     return new GoalResource(Goal::create($request->all()));
    //     //return response()->json(['message' => 'Goal created successfully']);
    // }

    public function store(StoreGoalRequest $request)
    {
        try {
            // Get user id from jwt token
            $user = auth()->user();

            // Add user id to the request
            $request->merge(['userID' => $user->id]);

            // Validate the incoming request
            $validatedData = $request->validated();

            $validatedData['userID'] = $user->id;

            // Calculate remaining save
            $remainingSave = $validatedData['amount'] - $validatedData['currentSave'];

            // Check if currentSave is greater than amount
            if ($remainingSave < 0) {
                throw new \Exception('Current save cannot be greater than the goal amount.');
            }

            // Additional validation logic
            if ($validatedData['setDate'] == 0) {
                // Ensure that startDate and endDate are null or not present when setDate is 0
                if (!isset($validatedData['startDate']) && !isset($validatedData['endDate'])) {

                    // Validate monthly contribution
                    if (!isset($validatedData['monthlyContribution'])) {
                        throw new \Exception('Monthly contribution is required when set date is disabled.');
                    }
                    // Set startDate as currentDate
                    $validatedData['startDate'] = Carbon::now()->toDateString();
                    // Calculate endDate based on monthly contribution and remaining save
                    $monthlyContribution = $validatedData['monthlyContribution'];
                    $endDate = Carbon::now()->addMonths(ceil($remainingSave / $monthlyContribution))->toDateString();
                    $validatedData['endDate'] = $endDate;

                    //$goal->update(['startDate' => null, 'endDate' => null]); // Update startDate and endDate to null
                } elseif (isset($validatedData['startDate']) || isset($validatedData['endDate'])) {
                    throw new \Exception('Start date and end date must be null or not present when set date is disabled.');
                }
            } else {
                //Ensure that startDate and endDate are present and valid if setDate is 1
                if ($validatedData['setDate'] == 1 && (!isset($validatedData['startDate']) || !isset($validatedData['endDate']))) {
                    throw new \Exception('Start date and end date are required when set date is enabled.');
                }

                // Check if monthlyContribution is provided when setDate is 1
                if (isset($validatedData['monthlyContribution'])) {
                    throw new \Exception('Monthly contribution should not be provided when set date is enabled.');
                }

                // Calculate monthly contribution if needed
                if (!isset($validatedData['monthlyContribution'])) {
                    // Calculate remaining months
                    $endDate = Carbon::parse($validatedData['endDate']);
                    $startDate = Carbon::parse($validatedData['startDate']);
                    $currentDate = Carbon::now();

                    // Calculate remaining months based on whether the start date is in the future or not
                    if ($startDate > $currentDate) {
                        // If start date is in the future, calculate remaining months from start date to end date
                        $remainingMonths = $startDate->diffInMonths($endDate);

                        $remainingDays = $startDate->diffInDays($endDate) - ($remainingMonths * 30);

                    } elseif ($startDate < $currentDate & $endDate < $currentDate) {

                        $remainingMonths = $startDate->diffInMonths($endDate);

                        $remainingDays = $startDate->diffInDays($endDate) - ($remainingMonths * 30);

                    } else {
                        // If start date is not provided or is in the past, calculate remaining months from current date to end date
                        $remainingMonths = $currentDate->diffInMonths($endDate);

                        $remainingDays = $currentDate->diffInDays($endDate) - ($remainingMonths * 30);
                    }

                    if ($remainingDays > 15) {
                        $remainingMonths++;
                    }

                    // Validate endDate
                    if ($endDate <= $startDate) {
                        throw new \Exception('End date must be after the start date.');
                    }

                    // Handle scenario where remaining time is less than 1 month
                    if ($remainingMonths == 0) {
                        $validatedData['monthlyContribution'] = $remainingSave;
                    } else {
                        // Calculate the monthly contribution needed to reach the target goal amount
                        $monthlyContribution = $remainingMonths > 0 ? round($remainingSave / $remainingMonths, 2) : 0;
                        // Update the monthlyContribution field
                        $validatedData['monthlyContribution'] = $monthlyContribution;
                    }
                }
            }

            // Update the remainingSave field in the validated data
            $validatedData['remainingSave'] = $remainingSave;

            // Create a new goal instance
            $goal = new Goal();

            // Populate the goal attributes with validated data
            $goal->fill($validatedData);

            // Save the goal to the database
            $goal->save();

            return new GoalResource($goal);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
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
    // public function update(UpdateGoalRequest $request, Goal $goal)
    // {
    //     // Logic to update a goal by ID
    //     // $goal->update($request->all());
    //     // return response()->json(['message' => 'Goal updated successfully']);

    //     // Check if the model is retrieved successfully
    //     if (!$goal) {
    //         return response()->json(['error' => 'Goal not found'], 404);
    //     }

    //     # add user id to the request
    //     $user = auth()->user();
    //     # check if the budget plan belongs to the user
    //     if ($goal->userID != $user->id) {
    //         return response()->json(['success' => 'false', 'message' => 'You are not authorized to delete this Smart Goal'], 403);
    //     }

    //     // Logic to update a budget plan by ID
    //     try {
    //         $goal->update($request->validated());
    //     } catch (Exception $e) {
    //         return response()->json(['success' => 'false', 'message' => 'Failed to update Smart Goal'], 500);
    //     }

    //     return response()->json(['success' => 'true', 'message' => 'Smart Goal updated successfully']);
    // }
    public function update(UpdateGoalRequest $request, Goal $goal)
    {
        // Check if the model is retrieved successfully
        if (!$goal) {
            return response()->json(['error' => 'Goal not found'], 404);
        }

        # add user id to the request
        $user = auth()->user();
        # check if the budget plan belongs to the user
        if ($goal->userID != $user->id) {
            return response()->json(['success' => 'false', 'message' => 'You are not authorized to delete this Smart Goal'], 403);
        }

        // Logic to update a budget plan by ID
        try {
            $validatedData = $request->validated();
            // Calculate remaining save
            $remainingSave = $validatedData['amount'] - $validatedData['currentSave'];

            // Check if currentSave is greater than amount
            if ($remainingSave < 0) {
                throw new \Exception('Current save cannot be greater than the goal amount.');
            }
            // Update the remainingSave field in the validated data
            $validatedData['remainingSave'] = $remainingSave;

            // Additional validation logic
            if ($validatedData['setDate'] == 0) {
                // Ensure that startDate and endDate are null or not present when setDate is 0
                if (!isset($validatedData['startDate']) && !isset($validatedData['endDate'])) {

                    if (!isset($validatedData['monthlyContribution'])) {
                        throw new \Exception('Monthly contribution is required when set date is disabled.');
                    }
                    $goal->update(['startDate' => null, 'endDate' => null]); // Update startDate and endDate to null
                } elseif (isset($validatedData['startDate']) || isset($validatedData['endDate'])) {
                    throw new \Exception('Start date and end date must be null or not present when set date is disabled.');
                }
            } else {
                //Ensure that startDate and endDate are present and valid if setDate is 1
                if ($validatedData['setDate'] == 1 && (!isset($validatedData['startDate']) || !isset($validatedData['endDate']))) {
                    throw new \Exception('Start date and end date are required when set date is enabled.');
                }

                // Check if monthlyContribution is provided when setDate is 1
                if (isset($validatedData['monthlyContribution'])) {
                    throw new \Exception('Monthly contribution should not be provided when set date is enabled.');
                }
                // Calculate monthly contribution if needed
                if (!isset($validatedData['monthlyContribution'])) {
                    // Calculate remaining months
                    $endDate = Carbon::parse($validatedData['endDate']);
                    $startDate = Carbon::parse($validatedData['startDate']);
                    $currentDate = Carbon::now();

                    // Calculate remaining months based on whether the start date is in the future or not
                    if ($startDate > $currentDate) {
                        // If start date is in the future, calculate remaining months from start date to end date
                        $remainingMonths = $startDate->diffInMonths($endDate);
                    } else {
                        // If start date is not provided or is in the past, calculate remaining months from current date to end date
                        $remainingMonths = $currentDate->diffInMonths($endDate);
                    }

                    // Validate endDate
                    if ($endDate <= $currentDate) {
                        throw new \Exception('End date must be in the future.');
                    }

                    // Calculate the monthly contribution needed to reach the target goal amount
                    $monthlyContribution = $remainingMonths > 0 ? round($remainingSave / $remainingMonths, 2) : 0;

                    // Update the monthlyContribution field
                    $validatedData['monthlyContribution'] = $monthlyContribution;
                }
            }
            $goal->update($validatedData);
        } catch (Exception $e) {
            return response()->json(['success' => 'false', 'message' => 'Failed to update Smart Goal'], 500);
        }

        return response()->json(['success' => 'true', 'message' => 'Smart Goal updated successfully']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Goal $goal)
    {
        $user = auth()->user();
        // Check if the authenticated user is the owner of the goal
        if ($goal->userID != $user->id) {
            return response()->json(['success' => 'false', 'message' => 'You are not authorized to delete this budget plan'], 403);
        }
        // Logic to delete a goal by ID
        $goal->delete();

        return response()->json(['success' => 'true', 'message' => 'Goal deleted successfully']);

    }
}
