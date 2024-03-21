<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreTransactionRequest;
use App\Http\Requests\V1\UpdateTransactionRequest;

use App\Models\User;
use App\Models\Transaction;
use App\Models\UpcomingBill;
use App\Models\BudgetPlan;
use App\Models\Category;
use App\Models\MyFinance;
use App\Models\Goal;
use App\Models\TransactionGoal;
use App\Http\Resources\V1\TransactionResource;
use App\Http\Resources\V1\TransactionGoalResource;

use App\Http\Resources\V1\TransactionCollection;

use App\Filters\V1\TransactionFilter;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(Request $request)
    {
        $user = auth()->user();

        $filter = new TransactionFilter();
        $queryItems = $filter->transform($request); //[['column', 'operator', 'value']]

        $query = Transaction::where('userID', $user->id);

        foreach ($queryItems as $item) {
            $query->where($item[0], $item[1], $item[2]);
        }

        $sortBy = $request->query('filter');

        // Apply sorting based on the filter parameter
        if ($sortBy === 'Recently') {
            $query->orderBy('date', 'desc');
        } elseif ($sortBy === 'Earliest') {
            $query->orderBy('date', 'asc');
        } elseif ($sortBy === 'Highest') {
            $query->orderBy('amount', 'desc');
        } elseif ($sortBy === 'Lowest') {
            $query->orderBy('amount', 'asc');
        } else {
            // Default sorting by created_at in descending order
            $query->orderBy('date', 'desc');
        }

        $transactions = $query->paginate();
        //$transactions = $query->orderBy('date', 'desc')->paginate();


        return new TransactionCollection($transactions->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        try {
            // Get user id from jwt token
            $user = auth()->user();

            // Add user id to the request
            $request->merge(['userID' => $user->id]);

            // Validate the incoming request
            $validatedData = $request->validated();

            // Check if categoryID is present in the request
            if ($request->has('categoryID')) {
                // Fetch the category details based on categoryID
                $category = Category::findOrFail($validatedData['categoryID']);

                // Automatically set isIncome based on the category's isIncome value
                $validatedData['isIncome'] = $category->isIncome;

                // Automatically set expenseType to "General"
                $validatedData['expenseType'] = "General";
                $validatedData['budgetplanID'] = null;
                $validatedData['upcomingbillID'] = null;
                $validatedData['hasContributed'] = 0;

                // If the category's isIncome is 1, set expenseType to "General"
                if ($category->isIncome == 1) {
                    // Automatically set isIncome based on the category's isIncome value
                    $validatedData['isIncome'] = $category->isIncome;
                    $validatedData['expenseType'] = "General";
                    $validatedData['budgetplanID'] = null;
                    $validatedData['upcomingbillID'] = null;
                    $validatedData['hasContributed'] = 0;
                }
            }

            // Check if upcomingbillID or budgetplanID is present in the request
            if ($request->has('upcomingbillID')) {
                // If upcomingbillID is present, set expenseType to 'Upcoming Bill'
                $validatedData['expenseType'] = 'Upcoming Bill';
                $validatedData['hasContributed'] = 0;
                $validatedData['budgetplanID'] = null;
                $validatedData['isIncome'] = 0;

                // Fetch the upcoming bill details based on upcomingbillID
                $upcomingBill = UpcomingBill::findOrFail($validatedData['upcomingbillID']);

                // Update categoryID and amount in the validatedData
                $validatedData['categoryID'] = $upcomingBill->categoryID;
                $validatedData['amount'] = $upcomingBill->amount;

                // Update the status of the upcoming bill to "paid"
                if (isset ($upcomingBill)) {
                    $upcomingBill->status = "paid";
                    $upcomingBill->save();
                }
            } elseif ($request->has('budgetplanID')) {
                $validatedData['expenseType'] = 'Budget Plan';
                $validatedData['hasContributed'] = 0;
                $validatedData['upcomingbillID'] = null;
                $validatedData['isIncome'] = 0;

                // Fetch the budget plan details based on budgetplanID
                $budgetPlan = BudgetPlan::findOrFail($validatedData['budgetplanID']);

                // Update categoryID and amount in the validatedData
                $validatedData['categoryID'] = $budgetPlan->categoryID;
            }

            $validatedData['userID'] = $user->id;

            if ($validatedData['isIncome']) {
                // Increment user net worth by $data['amount']
                MyFinance::where('userID', $user->id)->increment('totalbalance', $validatedData['amount']);
            } else {
                // Subtract from the net worth by $data['amount']
                MyFinance::where('userID', $user->id)->decrement('totalbalance', $validatedData['amount']);
            }
            

            // Check if contribution to smart goal is specified
            if ($request->has('contributions')) {
                // Retrieve contributions from the request
                $contributions = $request->input('contributions');

                // Calculate the total contribution amount
                $totalContribution = array_sum(array_column($contributions, 'contributionAmount'));

                // Deduct the total contribution amount from the original transaction amount
                $validatedData['amount'] -= $totalContribution;

                // Update the specified fields of the transaction
                $validatedData['expenseType'] = 'General';
                $validatedData['hasContributed'] = 1;
                $validatedData['upcomingbillID'] = null;
                $validatedData['budgetplanID'] = null;
                $validatedData['isIncome'] = 1;

                // Save the original transaction details to the transactions table
                $transaction = new Transaction();
                $transaction->fill($validatedData);
                $transaction->save();

                $transactionGoalsArray = [];
                // Process each contribution
                foreach ($contributions as $contribution) {
                    // Retrieve the corresponding goal based on the goalID
                    $goal = Goal::findOrFail($contribution['goalID']);

                    // Deduct the contribution amount from the remainingSave column of the goal
                    $goal->remainingSave -= $contribution['contributionAmount'];

                    // Increase the currentSave column of the goal based on the contribution amount
                    $goal->currentSave += $contribution['contributionAmount'];

                    // Save the updated goal details
                    $goal->save();

                    // Save the contribution details to the transaction_goals table
                    $transactionGoal = new TransactionGoal();
                    $transactionGoal->userID = $user->id;
                    $transactionGoal->transactionID = $transaction->id;
                    $transactionGoal->goalID = $contribution['goalID'];
                    $transactionGoal->ContributionAmount = $contribution['contributionAmount'];
                    $transactionGoal->save();

                    // Add transaction goal to the array
                    $transactionGoalsArray[] = new TransactionGoalResource($transactionGoal);
                }

                // Add transactionGoalsArray to the transaction object
                $transaction->transactionGoals = $transactionGoalsArray;

                // Return the response with the transaction object
                return response()->json([
                    'transaction' => new TransactionResource($transaction)
                ], 201);
            } else {
                // If no contribution to smart goal is specified, simply save the transaction
                $transaction = new Transaction();
                $transaction->fill($validatedData);
                $transaction->save();

                return new TransactionResource($transaction);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
    * Display the specified resource.
    **/
    public function show(Transaction $transaction)
    {
        // Logic to get a specific transaction by ID
        return new TransactionResource($transaction);
    }
    //return response()->json($transaction);


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        # add user id to the request
        $user = auth()->user();
        # check if the transaction belongs to the user
        if ($transaction->userID != $user->id) {
            return response()->json(['success' => 'false', 'message' => 'You are not authorized to delete this transaction'], 403);
        }

        // Logic to update a transaction by ID
        try {
            $validatedData = $request->validated();


            // Update Net worth if user supply new transaction amount
            if (isset($validatedData['amount'])) {
                // Query old amount
                $oldAmount = $transaction->amount;
                // Calculate the difference between the original amount and the updated amount
                $difference = $validatedData['amount'] - $oldAmount;
                
                if ($transaction->isIncome) {
                    // If the updated transaction is considered as income, add the difference to totalbalance
                    MyFinance::where('userID', $user->id)->increment('totalbalance', $difference);
                } else {
                    // If the updated transaction is considered as an expense, subtract the difference from totalbalance
                    MyFinance::where('userID', $user->id)->decrement('totalbalance', $difference);
                }
            }


            $transaction->update($validatedData);
        } catch (Exception $e) {
            return response()->json(['success' => 'false', 'message' => 'Failed to update transaction'], 500);
        }

        return response()->json(['success' => 'true', 'message' => 'Transaction updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $user = auth()->user();
        // Check if the authenticated user is the owner of the transaction
        if ($transaction->userID != $user->id) {
            return response()->json(['success' => 'false', 'message' => 'You are not authorized to delete this transaction'], 403);
        }
        // Logic to delete a transaction by ID
        $transaction->delete();
        // Logic to delete a transaction by ID
        return response()->json(['success' => 'true', 'message' => 'Transaction deleted successfully']);
    }
}
