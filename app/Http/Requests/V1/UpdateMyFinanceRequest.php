<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMyFinanceRequest extends FormRequest
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
                'sessionID' => 'sometimes|uuid',
                'totalbalance' => 'required|numeric|min:0',
                'currencyID' => 'sometimes|exists:currencies,id',
            ];
        } else {
            return [
                'sessionID' => 'sometimes|uuid',
                'totalbalance' => 'sometimes|required|numeric|min:0',
                'currencyID' => 'sometimes|required|exists:currencies,id',
            ];
        }
    }
}
