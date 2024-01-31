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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return[
            'name' => 'sometimes|required',
            'amount' => 'sometimes|required',
            'currentSave' => 'sometimes|required',
            'remainingSave' => 'sometimes|required',
            'setDate' => 'sometimes|required',
            'startDate' => 'sometimes|required',
            'endDate' => 'sometimes|required',
            'monthlyContribution' => 'sometimes|required',
            'created_at' => 'sometimes|required',
            'updated_at' => 'sometimes|required',
            ];
    }
}
