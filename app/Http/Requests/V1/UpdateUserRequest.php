<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            // return [
            // 'name' => 'sometimes|required',
            // 'email' => 'sometimes|required|email',
            // 'email_verified_at' => 'sometimes|required',
            // //'totalBalance' => 'sometimes|required|numeric',
            // 'created_at' => 'sometimes|required',
            // 'updated_at' => 'sometimes|required',
            // ];
            return [
                'name' => 'sometimes|required|string|max:50',
                'email' => 'sometimes|required|email|unique:users,email',
                //'password' => 'required|string|min:8',
            ];  
        } else {
            return [
                'name' => 'sometimes|required|string|max:50',
                'email' => 'sometimes|required|email|unique:users,email',
                //'password' => 'sometimes|required|string|min:8',
                // 'name' => 'sometimes|required',
                // 'email' => 'sometimes|required|email',
                // 'email_verified_at' => 'sometimes|required',
                // //'totalBalance' => 'sometimes|required',
                // 'created_at' => 'sometimes|required',
                // 'updated_at' => 'sometimes|required',
                // 'password' => ['sometimes|required'],
            ];
        }
        
    }
}