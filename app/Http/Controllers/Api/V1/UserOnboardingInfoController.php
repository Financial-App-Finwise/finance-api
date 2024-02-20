<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserOnboardingInfo;
use App\Models\OnboardingExpenseCategory;
use App\Http\Requests\V1\StoreUserOnboardingInfoRequest;
use App\Http\Requests\V1\UpdateUserOnboardingInfoRequest;
use App\Http\Resources\V1\UserOnboardingInfoResource;


class UserOnboardingInfoController extends Controller
{
    public function index()
    {
        // Get the authenticated user
        $user = auth()->user();

        // Retrieve the onboarding information for the authenticated user
        $userOnboardingInfo = UserOnboardingInfo::where('userID', $user->id)->get();

        return response()->json(['success' => true, 'data' => UserOnboardingInfoResource::collection($userOnboardingInfo)]);
    }

    public function store(StoreUserOnboardingInfoRequest $request)
    {
        // Validate and store a new UserOnboardingInfo record
        $validatedData = $request->validated();

        // Get the authenticated user
        $user = auth()->user();

        // Add the userID to the beginning of the $validatedData array
        $validatedData = collect($validatedData)->prepend($user->id, 'userID')->all();

        // Extract categories from the validated data
        $categories = $validatedData['categories'] ?? [];
    
        // Remove categories from the main data array
        unset($validatedData['categories']);
    
        // Create the UserOnboardingInfo record
        $userOnboardingInfo = UserOnboardingInfo::create($validatedData);
    
        foreach ($categories as $categoryId) {
            OnboardingExpenseCategory::create([
                'onboardingID' => $userOnboardingInfo->id,
                'categoryID' => $categoryId,
            ]);
        }
    
        // Return the resource
        return response()->json(['success'=> 'true', 'message' => 'User onboarding information stored successfully.', 'data' => new UserOnboardingInfoResource($userOnboardingInfo)]); 
        
    }

    public function update(UpdateUserOnboardingInfoRequest $request)
    {
        // Validate the request
        $validatedData = $request->validated();
    
        // Get the authenticated user
        $user = auth()->user();
    
        // Extract categories from the validated data
        $categories = $validatedData['categories'] ?? [];
    
        // Remove categories from the main data array
        unset($validatedData['categories']);
    
        // Find the UserOnboardingInfo record with the specified user ID and first() to get the actual model instance
        $onboardinginfo = UserOnboardingInfo::where('userID', $user->id)->first();
    
        // Check if the record exists
        if ($onboardinginfo) {
            // Update the UserOnboardingInfo record
            $onboardinginfo->update($validatedData);
    
            // Delete existing categories for the user onboarding info
            OnboardingExpenseCategory::where('onboardingID', $onboardinginfo->id)->delete();
    
            // Create new categories for the user onboarding info
            foreach ($categories as $categoryId) {
                OnboardingExpenseCategory::create([
                    'onboardingID' => $onboardinginfo->id,
                    'categoryID' => $categoryId,
                ]);
            }
    
            // Return the updated resource
            return response()->json(['success' => true, 'message' => 'User onboarding information updated successfully.', 'data' => new UserOnboardingInfoResource($onboardinginfo)]);
        } else {
            // If the record is not found, return an error response
            return response()->json(['success' => false, 'message' => 'User onboarding information not found.'], 404);
        }
    }
    
}
