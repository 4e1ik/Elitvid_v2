<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateImageRequest extends FormRequest
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
            'description_image' => 'nullable|string|max:5000',
            'color' => 'nullable|string|max:255',
            'texture' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'description_image.string' => 'Описание должно быть строкой.',
            'description_image.max' => 'Описание не должно превышать :max символов.',
            'color.string' => 'Цвет должен быть строкой.',
            'color.max' => 'Цвет не должен превышать :max символов.',
            'texture.string' => 'Текстура должна быть строкой.',
            'texture.max' => 'Текстура не должна превышать :max символов.',
        ];
    }
}
