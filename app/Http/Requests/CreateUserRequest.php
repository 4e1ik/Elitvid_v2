<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CreateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === UserRole::Admin;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', Password::min(10)->letters()->numbers()->mixedCase()],
            'role' => ['required', Rule::in(UserRole::values())],
            'active' => ['required', 'in:0,1'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'username.required' => 'Имя пользователя обязательно.',
            'username.max' => 'Имя пользователя не должно превышать :max символов.',
            'email.required' => 'Email обязателен.',
            'email.email' => 'Укажите корректный email.',
            'email.unique' => 'Пользователь с таким email уже существует.',
            'password.required' => 'Пароль обязателен.',
            'role.required' => 'Роль обязательна.',
            'role.in' => 'Выбрана некорректная роль.',
            'active.in' => 'Некорректный статус активности.',
        ];
    }
}
