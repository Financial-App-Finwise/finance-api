<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreGoalRequest extends FormRequest
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
        return[
            //'userID' => 'required|exists:users,id',
            'name' => 'required',
            'amount' => 'required',
            'currentSave' => 'required',
            //'remainingSave' => 'sometimes',
            'setDate' => 'required',
            'startDate' => 'sometimes',
            'endDate' => 'sometimes',
            'monthlyContribution' => 'sometimes',
            ];
    }
}
