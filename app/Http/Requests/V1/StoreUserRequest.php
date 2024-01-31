<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
        // return [
        //     'name' => ['required|string|max:50'],
        //     'email' => ['required|email|unique:users,email'],
        //     'email_verified_at' => ['sometimes|required'],
        //     //'totalBalance' => 'sometimes|required|numeric',
        //     'created_at' => ['sometimes|required'],
        //     'updated_at' => ['sometimes|required'],
        //     'password' => ['required'],
        // ];
        return [
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ];  
    }
}