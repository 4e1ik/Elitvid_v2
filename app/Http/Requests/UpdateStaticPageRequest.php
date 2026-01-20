<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaticPageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $staticPage = $this->route('static_page');
        
        // Получаем ID статической страницы для валидации уникальности slug
        $staticPageId = $staticPage instanceof \App\Models\StaticPage 
            ? $staticPage->id 
            : ($staticPage ?? null);
        
        return [
            'title' => 'nullable|string|min:3|max:500',
            'subtitle' => 'nullable|string|max:2000',
            'menu_name' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            'active' => 'nullable|in:0,1',
            'main_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'main_image_description' => 'nullable|string|max:5000',
            'menu_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'menu_image_description' => 'nullable|string|max:5000',
            'slug' => [
                'nullable',
                'string',
                'max:100',
                $staticPageId ? 'unique:static_pages,slug,' . $staticPageId : 'unique:static_pages,slug',
                'regex:/^[a-z0-9_]+$/',
            ],
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'gallery_descriptions' => 'nullable|array',
            'gallery_descriptions.*' => 'nullable|string|max:5000',
            'gallery_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'Поле "Заголовок (H1)" должно быть строкой.',
            'title.min' => 'Заголовок должен содержать минимум :min символов.',
            'title.max' => 'Заголовок не должен превышать :max символов.',
            'subtitle.string' => 'Поле "Подзаголовок" должно быть строкой.',
            'subtitle.max' => 'Подзаголовок не должен превышать :max символов.',
            'menu_name.string' => 'Поле "Название в меню" должно быть строкой.',
            'menu_name.max' => 'Название в меню не должно превышать :max символов.',
            'content.string' => 'Поле "Главный текст" должно быть строкой.',
            'meta_title.string' => 'Поле "Meta заголовок" должно быть строкой.',
            'meta_title.max' => 'Meta заголовок не должен превышать :max символов.',
            'meta_description.string' => 'Поле "Meta описание" должно быть строкой.',
            'meta_description.max' => 'Meta описание не должно превышать :max символов.',
            'active.in' => 'Поле "Активность" должно быть 0 или 1.',
            'main_image.image' => 'Главная картинка должна быть изображением.',
            'main_image.mimes' => 'Главная картинка должна быть в формате: jpeg, jpg, png или webp.',
            'main_image.max' => 'Размер главной картинки не должен превышать 10 МБ.',
            'main_image_description.string' => 'Описание главной картинки должно быть строкой.',
            'main_image_description.max' => 'Описание главной картинки не должно превышать :max символов.',
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
