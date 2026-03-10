<?php

namespace App\Http\Requests;

use App\Rules\UploadedImageRule;
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
            'slug' => 'nullable|string|max:255|unique:products,slug|regex:/^[a-z0-9-]+$/',
            'image' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    $productType = $this->input('product_type');
                    $imageCount = is_array($value) ? count(array_filter($value)) : 0;
                    
                    if ($productType === 'bench') {
                        // Для скамеек - ровно одна картинка
                        if ($imageCount !== 1) {
                            $fail('Для скамейки необходимо загрузить ровно одно изображение.');
                        }
                    } elseif ($productType === 'pot') {
                        // Для кашпо - хотя бы одна картинка
                        if ($imageCount < 1) {
                            $fail('Для кашпо необходимо загрузить хотя бы одно изображение.');
                        }
                    }
                },
            ],
            'image.*' => [
                'required',
                new UploadedImageRule(),
            ],
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
            'image.required' => 'Необходимо загрузить изображение.',
            'image.*.required' => 'Необходимо загрузить изображение.',
            'image.*.mimetypes' => 'Изображение должно быть в формате: jpeg, jpg, png, webp или heic.',
            'image.*.max' => 'Размер изображения не должен превышать 10 МБ.',
            'slug.max' => 'Slug не должен превышать :max символов.',
            'slug.unique' => 'Такой slug уже используется. Выберите другой.',
            'slug.regex' => 'Slug может содержать только латинские буквы в нижнем регистре, цифры и дефисы.',
        ];
    }
}
