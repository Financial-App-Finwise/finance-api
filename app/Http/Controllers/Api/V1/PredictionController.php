<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PredictionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $predictions = $user->predictions;
        return PredictionResource::collection($predictions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePredictionRequest $request)
    {
        $user = auth()->user();
        $predictionData = $request->validated();
        
        $existingPrediction = $user->predictions()->first();

        if ($existingPrediction) {
            // If a prediction already exists for the user, update it
            $existingPrediction->update($predictionData);
            return response()->json(['success' => true, 'data' => new PredictionResource($existingPrediction)]);
        } else {
            // If no prediction exists for the user, create a new one
            $predictionData['user_id'] = $user->id;
            $prediction = Prediction::create($predictionData);
            return response()->json(['success' => true, 'data' => new PredictionResource($existingPrediction)]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePredictionRequest $request, Prediction $prediction)
    {
        // Check if the model is retrieved successfully
        if (!$prediction) {
            return response()->json(['success' => false, 'message' => 'Prediction not found'], Response::HTTP_NOT_FOUND);
        }

        // Add user id to the request
        $user = auth()->user();

        // Check if the prediction belongs to the user
        if ($prediction->userID != $user->id) {
            return response()->json(['success' => false, 'message' => 'You are not authorized to update this prediction'], Response::HTTP_UNAUTHORIZED);
        }

        // Logic to update a prediction by ID
        try {
            $prediction->update($request->validated());
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update prediction'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'success' => true,
            'message' => 'Prediction updated successfully',
            'data' => $prediction->fresh()
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
