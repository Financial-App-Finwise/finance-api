<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreTransactionRequest;
use App\Http\Requests\V1\UpdateTransactionRequest;

use App\Models\User;
use App\Models\Transaction;
use App\Http\Resources\V1\TransactionResource;
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

        if (count($queryItems) == 0) {
            return new TransactionCollection(Transaction::where('userID', $user->id)->orderBy('created_at', 'desc')->paginate());
        } else {
            $query = Transaction::where('userID', $user->id);

            foreach ($queryItems as $item) {
                $query->where($item[0], $item[1], $item[2]);
            }

            $transaction = $query->orderBy('created_at', 'desc')->paginate();

            //$upcomingbill = UpcomingBill::where($queryItems)->paginate();

            return new TransactionCollection($transaction->appends($request->query()));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Logic to get a specific upcomingbill by ID
        $transaction = Transaction::find($id);
        return response()->json($transaction);
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

            $validatedData['userID'] = $user->id;

            // Create a new transaction instance
            $transaction = new Transaction();

            // Populate the transaction attributes with validated data
            $transaction->fill($validatedData);

            // Save the transaction to the database
            $transaction->save();

            return new TransactionResource($transaction);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        // Logic to get a specific transaction by ID
        return response()->json($transaction);
    }

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
