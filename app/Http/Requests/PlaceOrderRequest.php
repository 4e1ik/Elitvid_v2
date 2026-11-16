<?php

namespace App\Http\Requests;

use App\DTO\PlaceOrderData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;

class PlaceOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:1|max:50',
            'email' => 'required|email|max:50',
            'name_corp' => 'max:50',
            'phone' => [
                'required',
                'string',
                'regex:/^(29\d{7}|33\d{7}|44\d{7}|25\d{7}|9\d{9}|7\d{9})$/',
            ],
            'textarea' => 'max:100',
            'g-recaptcha-response' => ['required', function (string $attribute, mixed $value, \Closure $fail) {
                $g_response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => config('services.recaptcha.secret_key'),
                    'response' => $value,
                    'remoteip' => request()->ip(),
                ]);
                if (!$g_response->json('success')) {
                    $fail('Похоже, что вы - Робот!');
                }
            }],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Неверный формат номера телефона.',
        ];
    }

    public function toData(): PlaceOrderData
    {
        $corporation = trim((string) $this->input('name_corp', ''));
        $comment = trim((string) $this->input('textarea', ''));

        return new PlaceOrderData(
            name: (string) $this->input('name'),
            email: (string) $this->input('email'),
            phone: (string) $this->input('country', '').$this->input('phone'),
            corporationName: $corporation === '' ? null : $corporation,
            comment: $comment === '' ? null : $comment,
        );
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone' => preg_replace('/\D/', '', (string) $this->phone),
        ]);
    }
}
