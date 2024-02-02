<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;



class UpdateGoalRequest extends FormRequest
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
            return[
                'name' => 'required',
                'amount' => 'required||numeric',
                'currentSave' => 'required|numeric',
                'remainingSave' => 'required|numeric',
                'setDate' => 'required',
                'startDate' => 'required',
                'endDate' => 'required',
                'monthlyContribution' => 'required',
            ];
        } else {
            return[
                'name' => 'sometimes|required',
                'amount' => 'sometimes|required|numeric',
                'currentSave' => 'sometimes|required|numeric',
                'remainingSave' => 'sometimes|required|numeric',
                'setDate' => 'sometimes|required',
                'startDate' => 'sometimes|required',
                'endDate' => 'sometimes|required',
                'monthlyContribution' => 'sometimes|required',
            ];
        }
    }
}
