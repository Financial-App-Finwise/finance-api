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
     * Display the user's prediction.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing the user's prediction.
     */
    public function show()
    {
        // Get the authenticated user
        $user = auth()->user();

        // Retrieve the prediction associated with the user
        $prediction = Prediction::where('userID', $user->id)->first();

        // Check if the prediction exists
        if (!$prediction) {
            return response()->json(['success' => false, 'message' => 'Prediction not found']);
        }

        // Return JSON response containing the user's prediction
        return response()->json(['success' => true, 'data' => new PredictionResource($prediction)]);
    }

    /**
     * Store a newly created prediction.
     *
     * @param \App\Http\Requests\StorePredictionRequest $request The incoming request containing data for creating the prediction.
     * @return \Illuminate\Http\JsonResponse JSON response indicating success or failure of the operation, along with the created or updated prediction.
     */
    public function store(StorePredictionRequest $request)
    {
        // Get the authenticated user
        $user = auth()->user();

        // Validate the request data
        $predictionData = $request->validated();
        
        // Check if a prediction already exists for the user
        $existingPrediction = Prediction::where('userID', $user->id)->first();

        if ($existingPrediction) {
            // If a prediction already exists for the user, update it
            $existingPrediction->update($predictionData);
            return response()->json(['success' => true, 'data' => new PredictionResource($existingPrediction)]);
        } else {
            // If no prediction exists for the user, create a new one
            $predictionData['userID'] = $user->id;
            $prediction = Prediction::create($predictionData);
            return response()->json(['success' => true, 'data' => new PredictionResource($prediction)]);
        }
    }

    /**
     * Update the specified prediction.
     *
     * @param \App\Http\Requests\UpdatePredictionRequest $request The incoming request containing data for updating the prediction.
     * @return \Illuminate\Http\JsonResponse JSON response indicating success or failure of the operation, along with the updated prediction.
     */
    public function update(UpdatePredictionRequest $request)
    {
        // Get the authenticated user
        $user = auth()->user();

        // Retrieve the prediction associated with the user
        $prediction = Prediction::where('userID', $user->id)->first();

        // Check if the prediction exists
        if (!$prediction) {
            return response()->json(['success' => false, 'message' => 'Prediction not found']);
        }

        // Check if the prediction belongs to the user
        if ($prediction->userID != $user->id) {
            return response()->json(['success' => false, 'message' => 'You are not authorized to update this prediction']);
        }

        // Update the prediction
        try {
            $prediction->update($request->validated());
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update prediction']);
        }

        // Return JSON response indicating success and the updated prediction
        return response()->json([
            'success' => true,
            'message' => 'Prediction updated successfully',
            'data' => new PredictionResource($prediction->fresh())
        ]);
    }

    /**
     * Remove the specified prediction from storage.
     *
     * @return \Illuminate\Http\JsonResponse JSON response indicating success or failure of the operation.
     */
    public function destroy()
    {
        // Get the authenticated user
        $user = auth()->user();

        // Retrieve the prediction associated with the user
        $prediction = Prediction::where('userID', $user->id)->first();

        // Check if the prediction exists
        if (!$prediction) {
            return response()->json(['success' => false, 'message' => 'Prediction not found']);
        }

        // Check if the prediction belongs to the user
        if ($prediction->userID != $user->id) {
            return response()->json(['success' => false, 'message' => 'You are not authorized to delete this prediction']);
        }

        // Delete the prediction
        $prediction->delete();

        // Return JSON response indicating success
        return response()->json(['success' => true, 'message' => 'Prediction deleted successfully']);
    }
}
