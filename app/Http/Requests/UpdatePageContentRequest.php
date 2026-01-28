<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageContentRequest extends FormRequest
{
    /**
     * Определяет, авторизован ли пользователь на выполнение этого запроса.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Правила валидации для обновления контента страницы.
     */
    public function rules(): array
    {
        return [
            // Мета-теги
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',

            // Описание категории
            'category_description' => 'nullable|string',

            // Галерея
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',

            'gallery_descriptions' => 'nullable|array',
            'gallery_descriptions.*' => 'nullable|string|max:5000',

            // Активность галереи (чекбокс)
            'gallery_active' => 'nullable|boolean',
        ];
    }

    /**
     * Сообщения об ошибках валидации.
     */
    public function messages(): array
    {
        return [
            'meta_title.string' => 'Поле "Заголовок (Title)" должно быть строкой.',
            'meta_title.max' => 'Заголовок (Title) не должен превышать :max символов.',

            'meta_description.string' => 'Поле "Описание (Description)" должно быть строкой.',
            'meta_description.max' => 'Описание (Description) не должно превышать :max символов.',

            'category_description.string' => 'Поле "Описание" должно быть строкой.',

            'gallery_images.array' => 'Галерея должна быть массивом файлов.',
            'gallery_images.*.image' => 'Каждый файл в галерее должен быть изображением.',
            'gallery_images.*.mimes' => 'Изображения в галерее должны быть в формате: jpeg, jpg, png или webp.',
            'gallery_images.*.max' => 'Размер изображения в галерее не должен превышать 10 МБ.',

            'gallery_descriptions.array' => 'Описания изображений должны быть массивом.',
            'gallery_descriptions.*.string' => 'Описание изображения должно быть строкой.',
            'gallery_descriptions.*.max' => 'Описание изображения не должно превышать :max символов.',

            'gallery_active.boolean' => 'Поле "Галерея активна" должно быть логическим значением.',
        ];
    }
}

