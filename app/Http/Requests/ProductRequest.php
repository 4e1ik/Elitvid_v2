<?php

namespace App\Http\Requests;

use App\Http\Controllers\PostController;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'content' => 'required|filled|min:10|max:10000',
            'type' => 'required|filled',
            'image.*' => 'required|image|mimes:jpeg,jpg,png,webp'
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
