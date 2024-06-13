<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        $rules = [
            'title' => 'required|string',
            'content' => 'nullable|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'user_id' => 'required|integer|exists:users,id',
        ];

        return $rules;
    }
}
