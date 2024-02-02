<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
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
                //'userID' => 'required|exists:users,id',
                'name' => 'required',
                'isIncome' => 'required',
                'parentID' => 'required',
                'level' => 'required',
                'isOnboarding' => 'required',
            ];
        } else {
            return [
                //'userID' => 'required|exists:users,id',
                'name' => 'sometimes|required',
                'isIncome' => 'sometimes|required',
                'parentID' => 'sometimes|required',
                'level' => 'sometimes|required',
                'isOnboarding' => 'sometimes|required',
            ];
        }
    }

}
