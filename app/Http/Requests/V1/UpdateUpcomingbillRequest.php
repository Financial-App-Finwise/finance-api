<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUpcomingbillRequest extends FormRequest
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
                'amount' => 'required',
                'date' => 'required|date_format:Y-m-d H:i:s',
                'name' => 'sometimes',
                'note' => 'sometimes',
            ];
        } else {
            return [
                'categoryID' => 'sometimes',
                'amount' => 'sometimes',
                'date' => 'sometimes|date_format:Y-m-d H:i:s',
                'name' => 'sometimes',
                'note' => 'sometimes',
            ];
        }
    }
}
