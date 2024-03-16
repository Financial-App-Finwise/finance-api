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
    public function index()
    {
        $user = auth()->user();
        $userOnboardingInfo = UserOnboardingInfo::where('userID', $user->id)->get();

        return response()->json(['success' => true, 'data' => UserOnboardingInfoResource::collection($userOnboardingInfo)]);
    }

    public function create(StoreUserOnboardingInfoRequest $request)
    {
        $validatedData = $request->validated();
        $user = auth()->user();

        // Create the UserOnboardingInfo record without associating it with a user
        $userOnboardingInfo = UserOnboardingInfo::create(array_merge($validatedData, ['userID' => $user->id]));

        // Add data to MyFinance model without associating it with a user
        MyFinance::create(['userID' => $user->id, 'totalbalance' => $validatedData['net_worth'], 'currencyID' => $validatedData['currencyID']]);

        // Extract categories and amounts from the validated data
        $categories = $validatedData['categories'] ?? [];
        $parentCategories = $validatedData['parentCategories'] ?? [];

        foreach ($categories as $category) {
            OnboardingExpenseCategory::create([
                'onboardingID' => $userOnboardingInfo->id,
                'categoryID' => $category['categoryID']
            ]);
        }

        foreach ($parentCategories as $parentCategory) {
            OnboardingExpenseCategory::create([
                'onboardingID' => $userOnboardingInfo->id,
                'parentID' => $parentCategory['parentID'],
                'amount' => $parentCategory['amount']
            ]);
        }

        // Return the resource
        return response()->json(['success' => true, 'message' => 'User onboarding information stored successfully.']);
    }

    
    public function update(UpdateUserOnboardingInfoRequest $request)
    {
        $validatedData = $request->validated();
        $user = auth()->user();
        
        // Extract categories and amounts from the validated data
        $categoryAmounts = $validatedData['categories'] ?? [];
        
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
            foreach ($categoryAmounts as $categoryId => $amount) {
                OnboardingExpenseCategory::create([
                    'onboardingID' => $onboardinginfo->id,
                    'categoryID' => $categoryId,
                    'amount' => $amount,
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
