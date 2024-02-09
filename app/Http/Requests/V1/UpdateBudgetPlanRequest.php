<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBudgetPlanRequest extends FormRequest
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
            //
            'categoryID' => 'sometimes|required|exists:categories,id',
            'isMonthly' => 'required|in:0,1',
            'name' => 'sometimes|required|string|max:50',
            'amount' => 'sometimes|required|numeric|min:0',
        ];
    }
}
