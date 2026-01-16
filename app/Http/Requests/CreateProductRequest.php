<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'product_type' => 'required|string|in:pot,bench',
            'material' => 'required|filled|min:3|max:100',
            'data' => [
                'required',
                'array',
                'min:1',
                function ($attribute, $value, $fail) {
                    // Проверяем, что хотя бы один вариант заполнен (size, weight или price)
                    $hasFilledVariant = false;
                    foreach ($value as $index => $variant) {
                        if (!empty($variant['size']) || !empty($variant['weight']) || !empty($variant['price'])) {
                            $hasFilledVariant = true;
                            break;
                        }
                    }
                    if (!$hasFilledVariant) {
                        $fail('Необходимо заполнить хотя бы одно поле (размер, вес или цена) хотя бы для одного варианта товара.');
                    }
                },
            ],
            'data.*.size' => 'nullable|max:50',
            'data.*.weight' => 'nullable|max:50',
            'data.*.price' => 'nullable|max:50',
            'collection' => 'required|filled',
            'active' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:5000',
            'image' => 'required',
            'image.*' => 'required|image|mimes:jpeg,jpg,png,webp|max:10240',
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
            'name.required' => 'Поле "Название товара" обязательно для заполнения.',
            'name.filled' => 'Поле "Название товара" не может быть пустым.',
            'name.min' => 'Название товара должно содержать минимум :min символов.',
            'name.max' => 'Название товара не должно превышать :max символов.',
            'material.required' => 'Поле "Материал" обязательно для заполнения.',
            'material.filled' => 'Поле "Материал" не может быть пустым.',
            'material.min' => 'Материал должен содержать минимум :min символов.',
            'material.max' => 'Материал не должен превышать :max символов.',
            'data.required' => 'Необходимо добавить хотя бы один вариант товара.',
            'data.array' => 'Варианты должны быть массивом.',
            'data.min' => 'Необходимо добавить хотя бы один вариант товара.',
            'data.*.size.max' => 'Размер не должен превышать :max символов.',
            'data.*.weight.max' => 'Вес не должен превышать :max символов.',
            'data.*.price.max' => 'Цена не должна превышать :max символов.',
            'collection.required' => 'Необходимо выбрать коллекцию.',
            'collection.filled' => 'Поле "Коллекция" не может быть пустым.',
            'active.boolean' => 'Поле "Активность" должно быть логическим значением.',
            'meta_title.max' => 'Meta Title не должен превышать :max символов.',
            'meta_description.max' => 'Meta Description не должен превышать :max символов.',
            'image.required' => 'Необходимо загрузить хотя бы одно изображение.',
            'image.*.required' => 'Необходимо загрузить хотя бы одно изображение.',
            'image.*.image' => 'Загруженный файл должен быть изображением.',
            'image.*.mimes' => 'Изображение должно быть в формате: jpeg, jpg, png или webp.',
            'image.*.max' => 'Размер изображения не должен превышать 10 МБ.',
        ];
    }
}
