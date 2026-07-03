<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Validator;

class UpdateUserRequest extends FormRequest
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
        $user = $this->route('user');

        return [
            'username' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', Password::min(10)->letters()->numbers()->mixedCase()],
            'role' => ['required', Rule::in(UserRole::values())],
            'active' => ['required', 'in:0,1'],
        ];
    }

    protected function prepareForValidation(): void
    {
        /** @var \App\Models\User $user */
        $user = $this->route('user');

        if ($user->id === $this->user()?->id) {
            $this->merge(['role' => $user->role->value]);
        }
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            /** @var \App\Models\User $user */
            $user = $this->route('user');

            if ($user->id === $this->user()?->id && $this->input('role') !== $user->role->value) {
                $validator->errors()->add('role', 'Нельзя изменить роль своего аккаунта.');
            }
        });
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
            'role.required' => 'Роль обязательна.',
            'role.in' => 'Выбрана некорректная роль.',
            'active.in' => 'Некорректный статус активности.',
        ];
    }
}
