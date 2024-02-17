<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\OnboardingExpenseCategoryResource;

class UserOnboardingInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'userID' => $this->userID,
            'gender' => $this->gender,
            'age' => $this->age,
            'marital_status' => $this->marital_status,
            'life_stage' => $this->life_stage,
            'daily_expense' => $this->daily_expense,
            'weekly_expense' => $this->weekly_expense,
            'monthly_expense' => $this->monthly_expense,
            'daily_income' => $this->daily_income,
            'weekly_income' => $this->weekly_income,
            'monthly_income' => $this->monthly_income,
            'categories' => OnboardingExpenseCategoryResource::collection($this->onboardingExpenseCategories),
            'financial_goal' => $this->financial_goal,
            'dream_amount' => $this->dream_amount,
            'envision_date' => $this->envision_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
