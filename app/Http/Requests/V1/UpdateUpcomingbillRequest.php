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
        return false;
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
                'categoryID' => 'sometimes|required',
                'amount' => 'sometimes|required',
                'date' => 'sometimes|required|dateTime',
                'name' => 'sometimes|required',
                'note' => 'sometimes|required',
                'created_at' => 'sometimes|required',
                'updated_at' => 'sometimes|required',
            ];
        } else {
            return [
                'categoryID' => 'sometimes|required',
                'amount' => 'sometimes|required',
                'date' => 'sometimes|required|dateTime',
                'name' => 'sometimes|required',
                'note' => 'sometimes|required',
                'created_at' => 'sometimes|required',
                'updated_at' => 'sometimes|required',
            ];
        }
    }
}
