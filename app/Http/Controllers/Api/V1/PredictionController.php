<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\V1\StorePredictionRequest; 
use App\Http\Requests\V1\UpdatePredictionRequest;
use App\Models\Prediction;
use App\Http\Resources\V1\PredictionResource;
use App\Http\Resources\V1\PredictionCollection;

class PredictionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $prediction = Prediction::where('userID', $user->id)->first();
        return response()->json(['success' => true, 'data' => $prediction]);
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
        
        $existingPrediction = Prediction::where('userID', $user->id)->first();

        if ($existingPrediction) {
            // If a prediction already exists for the user, update it
            $existingPrediction->update($predictionData);
            return response()->json(['success' => true, 'data' => new PredictionResource($existingPrediction)]);
        } else {
            // If no prediction exists for the user, create a new one
            $predictionData['userID'] = $user->id;
            $prediction = Prediction::create($predictionData);
            return response()->json(['success' => true, 'data' => $prediction]);
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
    public function update(UpdatePredictionRequest $request)
    {
        // Add user id to the request
        $user = auth()->user();

        $prediction = Prediction::where('userID', $user->id)->first();
        // Check if the model is retrieved successfully
        if (!$prediction) {
            return response()->json(['success' => false, 'message' => 'Prediction not found']);
        }

        // Check if the prediction belongs to the user
        if ($prediction->userID != $user->id) {
            return response()->json(['success' => false, 'message' => 'You are not authorized to update this prediction']);
        }

        // Logic to update a prediction by ID
        try {
            $prediction->update($request->validated());
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update prediction']);
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
    public function destroy()
    {
        // Add user id to the request
        $user = auth()->user();

        $prediction = Prediction::where('userID', $user->id)->first(); // Fetch the prediction
        // Check if the model is retrieved successfully
        if (!$prediction) {
            return response()->json(['success' => false, 'message' => 'Prediction not found']); // Fix array syntax
        }

        // Check if the prediction belongs to the user
        if ($prediction->userID != $user->id) {
            return response()->json(['success' => false, 'message' => "You are not authorized to update this prediction"]); // Fix array syntax and string
        }

        // Logic to delete a prediction by ID
        $prediction->delete();

        return response()->json(['success' => true, 'message' => 'Prediction deleted successfully']);
    }
}
