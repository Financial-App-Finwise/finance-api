<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;



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
            return [
                'name' => 'required',
                'amount' => 'required|numeric',
                'currentSave' => 'required|numeric',
                //'remainingSave' => 'sometimes|required|numeric',
                'setDate' => 'required|boolean',
                'startDate' => ($this->input('setDate') == 0) ? 'nullable' : 'sometimes|date',
                'endDate' => ($this->input('setDate') == 0) ? 'nullable' : 'sometimes|date',
                //'monthlyContribution' => 'sometimes|numeric',
                'monthlyContribution' => ($this->input('setDate') == 0) ? 'sometimes|required|numeric' : 'nullable',

            ];
        } else {
            return [
                'name' => 'sometimes|required',
                'amount' => 'sometimes|required|numeric',
                'currentSave' => 'sometimes|required|numeric',
                //'remainingSave' => 'sometimes|required|numeric',
                'setDate' => 'sometimes|required|boolean',
                'startDate' => ($this->input('setDate') == 0) ? 'nullable' : 'sometimes|required|date',
                'endDate' => ($this->input('setDate') == 0) ? 'nullable' : 'sometimes|required|date',
                'monthlyContribution' => 'sometimes|numeric',
            ];
        }
    }
}
