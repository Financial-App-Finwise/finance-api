<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'categoryID' => 'sometimes',
            'isIncome' => 'required',
            'amount' => 'required|numeric',
            'hasContributed' => 'sometimes|boolean',
            'upcomingbillID' => 'sometimes',
            'budgetplanID' => 'sometimes',
            'goalID' => 'sometimes', // Add this rule to allow specifying a goal ID
            'contributionAmount' => 'sometimes|numeric',
            'expenseType' => 'required',
            'date' => 'required',
            'note' => 'sometimes',
        ];
    }
}