<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest
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
        $method = $this->method();
        if ($method == 'PUT') {
            return [
                'categoryID' => 'required',
                'isIncome' => 'required',
                'amount' => 'required',
                'hasContributed' => 'sometimes|boolean',
                'upcomingbillID' => 'sometimes',
                'budgetplanID' => 'sometimes',
                'expenseType' => 'required',
                'date' => 'required',
                'note' => 'sometimes',
            ];
        } else {
            return [
                'categoryID' => 'sometimes|required',
                'isIncome' => 'sometimes|required',
                'amount' => 'sometimes|required|numeric',
                'hasContributed' => 'sometimes|required|boolean',
                'upcomingbillID' => 'sometimes|required',
                'budgetplanID' => 'sometimes|required',
                'expenseType' => 'sometimes|required',
                'date' => 'sometimes|required',
                'note' => 'sometimes|sometimes',
            ];
        }
    }
}