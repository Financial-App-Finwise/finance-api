<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreGoalRequest;
use App\Http\Requests\V1\UpdateGoalRequest;

use App\Models\User;
use App\Models\Goal;
use App\Models\TransactionGoal;
use App\Http\Resources\V1\GoalResource;
use App\Http\Resources\V1\GoalCollection;

use App\Filters\V1\GoalFilter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



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

        // Filter by year and group by month only if year is provided
        $year = $request->get('year');
        $month = $request->get('month');
        if ($year) {
            $startDate = Carbon::createFromFormat('Y', $year)->startOfYear();
            $endDate = Carbon::createFromFormat('Y', $year)->endOfYear();
            $query->whereBetween('endDate', [$startDate, $endDate]);

            // Group goals by month
            $goalsByMonth = $query->get()->groupBy(function ($goal) {
                return Carbon::parse($goal->endDate)->format('F'); // Group by month name
            });

            // If a specific month is requested, return goals for that month and the total count
            if ($month) {
                $goalsForMonth = $goalsByMonth->get($month, collect());
                return [
                    'Total SMART Goal' => $goalsForMonth->count(),
                    'goals' => $goalsForMonth,
                ];
            }

            // If no specific month is requested, return the count of goals for each month in the year
            $months = collect();
            for ($i = 1; $i <= 12; $i++) {
                $monthName = Carbon::createFromFormat('m', $i)->format('F');
                $goalsForMonth = $goalsByMonth->get($monthName, collect()); // Use month name to fetch goals
                $months->put($monthName, ['Number of goals' => $goalsForMonth->count()]); // Put count of goals for the month
            }

            return $months;
        }

        //Fetch paginated goals if year is not provided
        $goals = $query->orderBy('id', 'desc')->paginate();

        // Retrieve transaction counts for each goal
        foreach ($goals as $goal) {
            $transactionCount = $goal->transactionGoal()->count();
            $goal->transactionCount = $transactionCount; // Add transaction count to each goal object
        }
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
                if (!isset ($validatedData['startDate']) && !isset ($validatedData['endDate'])) {

                    // Validate monthly contribution
                    if (!isset ($validatedData['monthlyContribution'])) {
                        throw new \Exception('Monthly contribution is required when set date is disabled.');
                    }
                    // Set startDate as currentDate
                    $validatedData['startDate'] = Carbon::now()->toDateString();
                    // Calculate endDate based on monthly contribution and remaining save
                    $monthlyContribution = $validatedData['monthlyContribution'];
                    $endDate = Carbon::now()->addMonths(ceil($remainingSave / $monthlyContribution))->toDateString();
                    $validatedData['endDate'] = $endDate;

                    //$goal->update(['startDate' => null, 'endDate' => null]); // Update startDate and endDate to null
                } elseif (isset ($validatedData['startDate']) || isset ($validatedData['endDate'])) {
                    throw new \Exception('Start date and end date must be null or not present when set date is disabled.');
                }
            } else {
                //Ensure that startDate and endDate are present and valid if setDate is 1
                if ($validatedData['setDate'] == 1 && (!isset ($validatedData['startDate']) || !isset ($validatedData['endDate']))) {
                    throw new \Exception('Start date and end date are required when set date is enabled.');
                }

                // Check if monthlyContribution is provided when setDate is 1
                if (isset ($validatedData['monthlyContribution'])) {
                    throw new \Exception('Monthly contribution should not be provided when set date is enabled.');
                }

                // Calculate monthly contribution if needed
                if (!isset ($validatedData['monthlyContribution'])) {
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
     * Show the form for editing the specified resource.
     */


    public function show(Goal $goal)
    {
        $filter = request('filter', null);

        // Load transactions relationship and apply sorting based on the request
        $transactions = $goal->transactions();

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

        // Now, retrieve the sorted transactions
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
        $goal['amount'] = (float) $goal['amount'];
        $goal['transactions_count'] = (int) $sortedTransactions->count();

        // Modify the grouped transactions to include ContributionAmount for each transaction
        $groupedTransactions->transform(function ($transactions) {
            return $transactions->map(function ($transaction) {
                return [
                    'id' => $transaction->id,
                    'userID' => $transaction->userID,
                    'categoryID' => $transaction->categoryID,
                    'isIncome' => $transaction->isIncome,
                    'amount' => $transaction->amount,
                    'hasContributed' => $transaction->hasContributed,
                    'upcomingbillID' => $transaction->upcomingbillID,
                    'budgetplanID' => $transaction->budgetplanID,
                    'expenseType' => $transaction->expenseType,
                    'date' => $transaction->date,
                    'note' => $transaction->note,
                    'ContributionAmount' => $transaction->transactionGoal->ContributionAmount,
                ];
            });
        });

        // Add the modified grouped transactions to the response data
        $goal['transactions'] = $groupedTransactions;

        $sixMonthsAgo = Carbon::now()->subMonths(6);

        $contributionAmountsLast6Months = $goal->transactions()
            ->join('transaction_goals as tg', 'transactions.id', '=', 'tg.transactionID')
            ->where('tg.goalID', $goal->id) // Filter by goalID of current goal
            ->where('transactions.date', '>=', $sixMonthsAgo)
            ->groupBy(
                DB::raw('MONTHNAME(transactions.date)'), // Group by month name
                'transaction_goals.goalID' // Include goalID in GROUP BY clause
            )
            ->orderBy('transactions.date')
            ->get([
                DB::raw('MONTHNAME(transactions.date) as month'), // Format month as month name
                DB::raw('SUM(tg.ContributionAmount) as totalContribution'),
                'transaction_goals.goalID as laravel_through_key' // Alias the goalID for consistency
            ]);

        // Calculate the average total contribution
        $totalContributionSum = $contributionAmountsLast6Months->sum('totalContribution');
        $averageTotalContribution = $totalContributionSum / $contributionAmountsLast6Months->count();

        // Retrieve the total contribution in the last month
        $totalContributionLastMonth = $contributionAmountsLast6Months->last()->totalContribution ?? 0;

        $transactions = $goal->transactions()->with('goal')->get();

        $transactionContributions = $contributionAmountsLast6Months->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'userID' => $transaction->userID,
                'categoryID' => $transaction->categoryID,
                'isIncome' => $transaction->isIncome,
                'amount' => $transaction->amount,
                'hasContributed' => $transaction->hasContributed,
                'upcomingbillID' => $transaction->upcomingbillID,
                'budgetplanID' => $transaction->budgetplanID,
                'expenseType' => $transaction->expenseType,
                'date' => $transaction->date,
                'note' => $transaction->note,
                'transactionGoal' => [
                    'id' => $transaction->laravel_through_key,
                    'ContributionAmount' => $transaction->totalContribution,
                ]
            ];
        });

        // Add the contribution amounts to the response data along with average and last month's contribution
        $goal['contribution_amounts_last_6_months'] = $contributionAmountsLast6Months;
        $goal['average_total_contribution'] = $averageTotalContribution;
        $goal['total_contribution_last_month'] = $totalContributionLastMonth;

        return response()->json(['success' => 'true', 'data' => $goal]);
    }

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
            return response()->json(['success' => 'false', 'message' => 'You are not authorized to update this Smart Goal'], 403);
        }

        // Logic to update a budget plan by ID
        try {
            $validatedData = $request->validated();

            $validatedData['userID'] = $user->id;

            // Calculate remaining save
            $remainingSave = $validatedData['amount'] - $validatedData['currentSave'];

            // Check if currentSave is greater than amount
            if ($remainingSave < 0) {
                throw new \Exception('Current save cannot be greater than the goal amount.');
            }
            // Update the remainingSave field in the validated data
            $validatedData['remainingSave'] = $remainingSave;

            // Check if currentSave is greater than amount
            if ($remainingSave < 0) {
                throw new \Exception('Current save cannot be greater than the goal amount.');
            }
            // Additional validation logic
            if ($validatedData['setDate'] == 0) {
                // Ensure that startDate and endDate are null or not present when setDate is 0
                if (!isset ($validatedData['startDate']) && !isset ($validatedData['endDate'])) {

                    // Validate monthly contribution
                    if (!isset ($validatedData['monthlyContribution'])) {
                        throw new \Exception('Monthly contribution is required when set date is disabled.');
                    }
                    $goal->update(['startDate' => null, 'endDate' => null]); // Update startDate and endDate to null

                    // Set startDate as currentDate
                    $validatedData['startDate'] = Carbon::now()->toDateString();
                    // Calculate endDate based on monthly contribution and remaining save
                    $monthlyContribution = $validatedData['monthlyContribution'];
                    $endDate = Carbon::now()->addMonths(ceil($remainingSave / $monthlyContribution))->toDateString();
                    $validatedData['endDate'] = $endDate;

                } elseif (isset ($validatedData['startDate']) || isset ($validatedData['endDate'])) {
                    throw new \Exception('Start date and end date must be null or not present when set date is disabled.');
                }
            } else {
                //Ensure that startDate and endDate are present and valid if setDate is 1
                if ($validatedData['setDate'] == 1 && (!isset ($validatedData['startDate']) || !isset ($validatedData['endDate']))) {
                    throw new \Exception('Start date and end date are required when set date is enabled.');
                }

                // Check if monthlyContribution is provided when setDate is 1
                if (isset ($validatedData['monthlyContribution'])) {
                    throw new \Exception('Monthly contribution should not be provided when set date is enabled.');
                }
                // Calculate monthly contribution if needed
                if (!isset ($validatedData['monthlyContribution'])) {
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
