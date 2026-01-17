<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'product_type' => 'nullable|string|in:pot,bench',
            'material' => 'required|filled|min:3|max:100',
            'data' => 'nullable|array',
            'data.*.size' => 'nullable|max:50',
            'data.*.weight' => 'nullable|max:50',
            'data.*.price' => 'nullable|max:50',
            'collection' => 'required|filled',
            'active' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:5000',
            'image' => [
                'nullable',
                'array',
                function ($attribute, $value, $fail) {
                    $product = $this->route('product');
                    $productType = $this->input('product_type') ?? ($product ? $product->product_type : null);
                    
                    if (!$productType) {
                        return;
                    }

                    $newImagesCount = is_array($value) ? count(array_filter($value)) : 0;
                    
                    if ($productType === 'bench' && $newImagesCount > 1) {
                        $fail('Для скамейки можно загрузить только одно изображение.');
                    }
                },
            ],
            'image.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
        ];
    }

    /**
     * Настройка валидатора для проверки количества изображений
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $product = $this->route('product');
            $productType = $this->input('product_type') ?? ($product ? $product->product_type : null);
            
            if (!$productType || !$product) {
                return;
            }

            $newImagesCount = $this->hasFile('image') && is_array($this->file('image')) 
                ? count(array_filter($this->file('image'))) 
                : 0;
            $existingImagesCount = $product->images()->count();
            $totalImagesCount = $existingImagesCount + $newImagesCount;

            if ($productType === 'bench') {
                // Для скамеек - должно быть ровно одно изображение
                if ($totalImagesCount === 0) {
                    $validator->errors()->add('image', 'Для скамейки необходимо загрузить одно изображение.');
                } elseif ($totalImagesCount > 1) {
                    $validator->errors()->add('image', 'Для скамейки должно быть только одно изображение. Удалите существующие изображения перед загрузкой нового.');
                }
            } elseif ($productType === 'pot') {
                // Для кашпо - должно быть хотя бы одно изображение
                if ($totalImagesCount === 0) {
                    $validator->errors()->add('image', 'Для кашпо необходимо загрузить хотя бы одно изображение.');
                }
            }
        });
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
            'data.array' => 'Варианты должны быть массивом.',
            'data.*.size.max' => 'Размер не должен превышать :max символов.',
            'data.*.weight.max' => 'Вес не должен превышать :max символов.',
            'data.*.price.max' => 'Цена не должна превышать :max символов.',
            'collection.required' => 'Необходимо выбрать коллекцию.',
            'collection.filled' => 'Поле "Коллекция" не может быть пустым.',
            'active.boolean' => 'Поле "Активность" должно быть логическим значением.',
            'meta_title.max' => 'Meta Title не должен превышать :max символов.',
            'meta_description.max' => 'Meta Description не должен превышать :max символов.',
            'image.*.image' => 'Загруженный файл должен быть изображением.',
            'image.*.mimes' => 'Изображение должно быть в формате: jpeg, jpg, png или webp.',
            'image.*.max' => 'Размер изображения не должен превышать 10 МБ.',
        ];
    }
}
