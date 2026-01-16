<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaticPageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $method = $this->method();
        
        if ($method === 'POST') {
            // При создании все поля обязательны, кроме галереи
            $rules = [
                'title' => 'required|string|min:3|max:500',
                'subtitle' => 'required|string|min:3|max:2000',
                'menu_name' => 'required|string|min:1|max:255',
                'content' => 'required|string|min:10',
                'meta_title' => 'required|string|min:3|max:255',
                'meta_description' => 'required|string|min:10|max:1000',
                'active' => 'nullable|boolean',
                'main_image' => 'required|image|mimes:jpeg,jpg,png,webp|max:10240',
                'main_image_description' => 'nullable|string|max:5000',
                'menu_image' => 'required|image|mimes:jpeg,jpg,png,webp|max:10240',
                'menu_image_description' => 'nullable|string|max:5000',
                'slug' => 'nullable|string|max:100|unique:static_pages,slug|regex:/^[a-z0-9_]+$/',
                // Галерея необязательна
                'gallery_images' => 'nullable|array',
                'gallery_images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
                'gallery_descriptions' => 'nullable|array',
                'gallery_descriptions.*' => 'nullable|string|max:5000',
                'gallery_active' => 'nullable|boolean',
            ];
        } else {
            // При обновлении поля необязательны (можно обновлять частично)
            $rules = [
                'title' => 'nullable|string|min:3|max:500',
                'subtitle' => 'nullable|string|max:2000',
                'menu_name' => 'nullable|string|max:255',
                'content' => 'nullable|string',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:1000',
                'active' => 'nullable|boolean',
                'main_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
                'main_image_description' => 'nullable|string|max:5000',
                'menu_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
                'menu_image_description' => 'nullable|string|max:5000',
                'slug' => 'nullable',
                'gallery_images' => 'nullable|array',
                'gallery_images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
                'gallery_descriptions' => 'nullable|array',
                'gallery_descriptions.*' => 'nullable|string|max:5000',
                'gallery_active' => 'nullable|boolean',
            ];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Поле "Заголовок (H1)" обязательно для заполнения.',
            'title.string' => 'Поле "Заголовок (H1)" должно быть строкой.',
            'title.min' => 'Заголовок должен содержать минимум :min символов.',
            'title.max' => 'Заголовок не должен превышать :max символов.',
            'subtitle.required' => 'Поле "Подзаголовок" обязательно для заполнения.',
            'subtitle.string' => 'Поле "Подзаголовок" должно быть строкой.',
            'subtitle.min' => 'Подзаголовок должен содержать минимум :min символов.',
            'subtitle.max' => 'Подзаголовок не должен превышать :max символов.',
            'menu_name.required' => 'Поле "Название в меню" обязательно для заполнения.',
            'menu_name.string' => 'Поле "Название в меню" должно быть строкой.',
            'menu_name.min' => 'Название в меню должно содержать минимум :min символов.',
            'menu_name.max' => 'Название в меню не должно превышать :max символов.',
            'content.required' => 'Поле "Главный текст" обязательно для заполнения.',
            'content.string' => 'Поле "Главный текст" должно быть строкой.',
            'content.min' => 'Главный текст должен содержать минимум :min символов.',
            'meta_title.required' => 'Поле "Meta заголовок" обязательно для заполнения.',
            'meta_title.string' => 'Поле "Meta заголовок" должно быть строкой.',
            'meta_title.min' => 'Meta заголовок должен содержать минимум :min символов.',
            'meta_title.max' => 'Meta заголовок не должен превышать :max символов.',
            'meta_description.required' => 'Поле "Meta описание" обязательно для заполнения.',
            'meta_description.string' => 'Поле "Meta описание" должно быть строкой.',
            'meta_description.min' => 'Meta описание должно содержать минимум :min символов.',
            'meta_description.max' => 'Meta описание не должно превышать :max символов.',
            'active.boolean' => 'Поле "Активность" должно быть логическим значением.',
            'main_image.required' => 'Главная картинка обязательна для загрузки.',
            'main_image.image' => 'Главная картинка должна быть изображением.',
            'main_image.mimes' => 'Главная картинка должна быть в формате: jpeg, jpg, png или webp.',
            'main_image.max' => 'Размер главной картинки не должен превышать 10 МБ.',
            'main_image_description.string' => 'Описание главной картинки должно быть строкой.',
            'main_image_description.max' => 'Описание главной картинки не должно превышать :max символов.',
            'menu_image.required' => 'Картинка меню обязательна для загрузки.',
            'menu_image.image' => 'Картинка меню должна быть изображением.',
            'menu_image.mimes' => 'Картинка меню должна быть в формате: jpeg, jpg, png или webp.',
            'menu_image.max' => 'Размер картинки меню не должен превышать 10 МБ.',
            'menu_image_description.string' => 'Описание картинки меню должно быть строкой.',
            'menu_image_description.max' => 'Описание картинки меню не должно превышать :max символов.',
            'gallery_images.array' => 'Галерея должна быть массивом.',
            'gallery_images.*.image' => 'Изображения в галерее должны быть изображениями.',
            'gallery_images.*.mimes' => 'Изображения в галерее должны быть в формате: jpeg, jpg, png или webp.',
            'gallery_images.*.max' => 'Размер изображений в галерее не должен превышать 10 МБ.',
            'gallery_descriptions.array' => 'Описания галереи должны быть массивом.',
            'gallery_descriptions.*.string' => 'Описания изображений должны быть строками.',
            'gallery_descriptions.*.max' => 'Описания изображений не должны превышать :max символов.',
            'gallery_active.boolean' => 'Поле "Активность галереи" должно быть логическим значением.',
            'slug.string' => 'Slug должен быть строкой.',
            'slug.max' => 'Slug не должен превышать :max символов.',
            'slug.unique' => 'Такой slug уже существует. Пожалуйста, используйте другой.',
            'slug.regex' => 'Slug может содержать только латинские буквы в нижнем регистре, цифры и подчеркивания.',
        ];
    }
}

