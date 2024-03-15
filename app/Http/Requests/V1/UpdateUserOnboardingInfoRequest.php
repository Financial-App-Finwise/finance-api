<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserOnboardingInfoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'userID' => 'exists:users,id',
            'sessionID' => 'uuid',
            'gender' => 'string|max:50',
            'age' => 'integer',
            'marital_status' => 'string|max:50',
            'life_stage' => 'string|max:50',
            'net_worth' => 'numeric',
            'currencyID' => 'required|exists:currencies,id',
            'daily_expense' => 'numeric',
            'weekly_expense' => 'numeric',
            'monthly_expense' => 'numeric',
            'daily_income' => 'numeric',
            'weekly_income' => 'numeric',
            'monthly_income' => 'numeric',
            'categories' => 'array',
            'categories.*' => 'integer',
            'financial_goal' => 'string|max:100',
            'dream_amount' => 'numeric',
            'envision_date' => 'date',
        ];
    }
}