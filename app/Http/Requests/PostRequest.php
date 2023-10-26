<?php

namespace App\Http\Requests;

use App\Http\Controllers\PostController;
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|filled|min:3|max:100',
            'content' => 'required|filled|min:10|max:1000',
            'item' => 'required|filled',
            'type' => 'required|filled',
            'active' => 'required|filled|boolean',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
