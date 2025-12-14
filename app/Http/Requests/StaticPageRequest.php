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
        return [
            'title' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'main_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'alt_image' => 'nullable|string|max:255',
        ];
    }
}

