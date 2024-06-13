<?php

namespace App\Http\Requests;

use App\Http\Controllers\PostController;
use Illuminate\Foundation\Http\FormRequest;

class PotProductRequest extends FormRequest
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
            'name' => 'required|filled|min:3|max:100',
            'material' => 'required|filled|min:3|max:100',
            'size' => 'required|filled|max:50',
            'weight' => 'required|filled|max:50',
            'price' => 'required|filled|max:50',
            'collection' => 'required|filled',
            'image.*.image' => 'required|image'
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
