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
        
        $rules = [
            'title' => 'nullable|string|max:500',
            'subtitle' => 'nullable|string',
            'menu_name' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'active' => 'nullable|boolean',
            'main_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'menu_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'gallery_descriptions.*' => 'nullable|string|max:5000',
        ];

        // При создании slug может быть пустым (будет сгенерирован), но если указан - должен быть уникальным
        if ($method === 'POST') {
            $rules['slug'] = 'nullable|string|max:100|unique:static_pages,slug';
        }

        return $rules;
    }
}

