<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
        return [
            //
            'comment' =>'sometimes|required|string',
            'user_id' =>'sometimes|required|integer',
            'post_id' =>'sometimes|required|integer',
            'like_id' =>'sometimes|required|integer',
        ];
    }
}
