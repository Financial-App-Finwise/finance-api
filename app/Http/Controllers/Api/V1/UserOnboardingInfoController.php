<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserOnboardingInfo;
use App\Models\MyFinance;
use App\Models\OnboardingExpenseCategory;
use App\Http\Requests\V1\StoreUserOnboardingInfoRequest;
use App\Http\Requests\V1\UpdateUserOnboardingInfoRequest;
use App\Http\Resources\V1\UserOnboardingInfoResource;

use Illuminate\Support\Str;


class UserOnboardingInfoController extends Controller
{
    /**
     * Display a listing of the user's onboarding information.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing the user's onboarding information.
     */
    public function index()
    {
        // Get the authenticated user
        $user = auth()->user();

        // Retrieve the user's onboarding information
        $userOnboardingInfo = UserOnboardingInfo::where('userID', $user->id)->get();

        // Return JSON response containing the user's onboarding information
        return response()->json(['success' => true, 'data' => UserOnboardingInfoResource::collection($userOnboardingInfo)]);
    }

    /**
     * Store the user's onboarding information.
     *
     * @param \App\Http\Requests\StoreUserOnboardingInfoRequest $request The incoming request containing data for creating the user's onboarding information.
     * @return \Illuminate\Http\JsonResponse JSON response indicating success or failure of the operation.
     */
    public function create(StoreUserOnboardingInfoRequest $request)
    {
        // Validate the request data
        $validatedData = $request->validated();

        // Get the authenticated user
        $user = auth()->user();

        // Create the UserOnboardingInfo record and associate it with the user
        $userOnboardingInfo = UserOnboardingInfo::create(array_merge($validatedData, ['userID' => $user->id]));

        // Add data to the MyFinance model and associate it with the user
        MyFinance::create(['userID' => $user->id, 'totalbalance' => $validatedData['net_worth'], 'currencyID' => $validatedData['currencyID']]);

        // Extract categories and amounts from the validated data
        $categories = $validatedData['categories'] ?? [];
        $parentCategories = $validatedData['parentCategories'] ?? [];

        // Create onboarding expense categories associated with the user's onboarding information
        foreach ($categories as $category) {
            OnboardingExpenseCategory::create([
                'onboardingID' => $userOnboardingInfo->id,
                'categoryID' => $category['categoryID']
            ]);
        }

        // Create parent categories associated with the user's onboarding information
        foreach ($parentCategories as $parentCategory) {
            OnboardingExpenseCategory::create([
                'onboardingID' => $userOnboardingInfo->id,
                'parentID' => $parentCategory['parentID'],
                'amount' => $parentCategory['amount']
            ]);
        }

        // Return JSON response indicating success
        return response()->json(['success' => true, 'message' => 'User onboarding information stored successfully.']);
    }
    
    /**
     * Update the user's onboarding information.
     *
     * @param \App\Http\Requests\UpdateUserOnboardingInfoRequest $request The incoming request containing data for updating the user's onboarding information.
     * @return \Illuminate\Http\JsonResponse JSON response indicating success or failure of the operation.
     */
    public function update(UpdateUserOnboardingInfoRequest $request)
    {
        // Validate the request data
        $validatedData = $request->validated();

        // Get the authenticated user
        $user = auth()->user();

        // Extract categories and amounts from the validated data
        $categoryAmounts = $validatedData['categories'] ?? [];

        // Remove categories from the main data array
        unset($validatedData['categories']);

        // Find the UserOnboardingInfo record with the specified user ID
        $onboardinginfo = UserOnboardingInfo::where('userID', $user->id)->first();

        // Check if the record exists
        if ($onboardinginfo) {
            // Update the UserOnboardingInfo record
            $onboardinginfo->update($validatedData);

            // Delete existing categories for the user onboarding info
            OnboardingExpenseCategory::where('onboardingID', $onboardinginfo->id)->delete();

            // Create new categories for the user onboarding info
            foreach ($categoryAmounts as $categoryId => $amount) {
                OnboardingExpenseCategory::create([
                    'onboardingID' => $onboardinginfo->id,
                    'categoryID' => $categoryId,
                    'amount' => $amount,
                ]);
            }

            // Return JSON response indicating success and the updated resource
            return response()->json(['success' => true, 'message' => 'User onboarding information updated successfully.', 'data' => new UserOnboardingInfoResource($onboardinginfo)]);
        } else {
            // If the record is not found, return a 404 error response
            return response()->json(['success' => false, 'message' => 'User onboarding information not found.'], 404);
        }
    }
}
