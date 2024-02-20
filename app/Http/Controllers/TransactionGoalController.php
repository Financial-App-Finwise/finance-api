<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreTransactionGoalRequest;
use App\Http\Requests\V1\UpdateTransactionGoalRequest;

use App\Models\User;
use App\Models\TransactionGoal;
use App\Http\Resources\V1\TransactionGoalResource;
use App\Http\Resources\V1\TransactionGoalCollection;

use App\Filters\V1\TransactionGoalFilter;

class TransactionGoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $user = auth()->user();

        $filter = new TransactionGoalFilter();
        $queryItems = $filter->transform($request); //[['column', 'operator', 'value']]

        if (count($queryItems) == 0) {
            return new TransactionGoalCollection(TransactionGoal::where('userID', $user->id)->orderBy('created_at', 'desc')->paginate());
        } else {
            $query = TransactionGoal::where('userID', $user->id);

            foreach ($queryItems as $item) {
                $query->where($item[0], $item[1], $item[2]);
            }

            $transactionGoal = $query->orderBy('created_at', 'desc')->paginate();

            return new TransactionGoalCollection($transactionGoal->appends($request->query()));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Logic to get a specific TransactionGoal by ID
        $transactionGoal = TransactionGoal::find($id);
        return response()->json($transactionGoal);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionGoalRequest $request)
    {
        try {
            // Get user id from jwt token
            $user = auth()->user();

            // Add user id to the request
            $request->merge(['userID' => $user->id]);

            // Validate the incoming request
            $validatedData = $request->validated();

            $validatedData['userID'] = $user->id;

            // Create a new transactionGoal instance
            $transactionGoal = new TransactionGoal();

            // Populate the transactionGoal attributes with validated data
            $transactionGoal->fill($validatedData);

            // Save the transactionGoal to the database
            $transactionGoal->save();

            return new TransactionGoalResource($transactionGoal);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(TransactionGoal $transactionGoal)
    {
        // Logic to get a specific transactionGoal by ID
        return response()->json($transactionGoal);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransactionGoal $transactionGoal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionGoalRequest $request, TransactionGoal $transactionGoal)
    {
        if (!$transactionGoal) {
            return response()->json(['error' => 'TransactionGoal not found'], 404);
        }

        # add user id to the request
        $user = auth()->user();
        # check if the transactionGoal belongs to the user
        if ($transactionGoal->userID != $user->id) {
            return response()->json(['success' => 'false', 'message' => 'You are not authorized to delete this transactionGoal'], 403);
        }

        // Logic to update a transactionGoal by ID
        try {
            $validatedData = $request->validated();
            $transactionGoal->update($validatedData);
        } catch (Exception $e) {
            return response()->json(['success' => 'false', 'message' => 'Failed to update transactionGoal'], 500);
        }

        return response()->json(['success' => 'true', 'message' => 'TransactionGoal updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransactionGoal $transactionGoal)
    {
        $user = auth()->user();
        // Check if the authenticated user is the owner of the transactionGoal
        if ($transactionGoal->userID != $user->id) {
            return response()->json(['success' => 'false', 'message' => 'You are not authorized to delete this transactionGoal'], 403);
        }
        // Logic to delete a transactionGoal by ID
        $transactionGoal->delete();
        // Logic to delete a transactionGoal by ID
        return response()->json(['success' => 'true', 'message' => 'TransactionGoal deleted successfully']);
    }
}