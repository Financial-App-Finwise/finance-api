<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreBudgetPlanRequest extends FormRequest
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
            'userID' => 'required|exists:users,id',
            'categoryID' => 'required|exists:categories,id',
            'isMonthly' => 'required|in:0,1',
            'name' => 'required|string|max:50',
            'amount' => 'required|numeric|min:0',
        ];
    }
}
