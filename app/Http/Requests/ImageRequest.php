<?php

namespace App\Http\Requests;

use App\Http\Controllers\ImageController;
use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
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
            'image' => 'image',
            'description_img' => 'min:3|max:100',
            //'type_img' => 'required|filled',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
