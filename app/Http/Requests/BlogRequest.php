<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('blogs', 'slug')->ignore($this->route('blog')?->id),
                'regex:/^[a-z0-9-]+$/',
            ],
            'active' => 'nullable|in:0,1',
            'main_image' => 'required|image|mimes:jpeg,jpg,png,webp|max:10240',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Заголовок поста обязателен.',
            'title.max' => 'Заголовок не должен превышать :max символов.',
            'description.required' => 'Краткое описание обязательно.',
            'description.max' => 'Краткое описание не должно превышать :max символов.',
            'slug.max' => 'Slug не должен превышать :max символов.',
            'slug.unique' => 'Такой slug уже используется. Выберите другой.',
            'slug.regex' => 'Slug может содержать только латинские буквы в нижнем регистре, цифры и дефисы.',
            'active.in' => 'Некорректный статус публикации.',
            'main_image.required' => 'Необходимо загрузить главное изображение.',
            'main_image.image' => 'Файл должен быть изображением.',
            'main_image.mimes' => 'Допустимые форматы: jpeg, jpg, png, webp.',
            'main_image.max' => 'Размер изображения не должен превышать 10 МБ.',
            'meta_title.max' => 'Meta Title не должен превышать :max символов.',
            'meta_description.max' => 'Meta Description не должна превышать :max символов.',
        ];
    }
}
