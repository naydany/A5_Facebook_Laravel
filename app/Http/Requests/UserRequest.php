<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        return [
            //
            'name' =>'sometimes|required|string|max:255',
            'email' =>'sometimes|required|string|email|max:255|unique:users',
            'password' =>'sometimes|required|string',
            'profile_image' =>'sometimes|required|string'
            // 'password_confirmation' =>'sometimes|required|string|min:8|confirmed',
        ];
    }
}
