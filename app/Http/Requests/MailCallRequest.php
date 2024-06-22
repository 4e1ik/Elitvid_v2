<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;

class MailCallRequest extends FormRequest
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
            'name' => 'required|min:3|max:30',
            'phone' => 'required|max:20',
            'g-recaptcha-response' => ['required', function (string $attribute, mixed $value, \Closure $fail){
                $g_response = Http::asForm()->post("https://www.google.com/recaptcha/api/siteverify",[
                    'secret' => config('services.recaptcha.secret_key'),
                    'response' => $value,
                    'remoteip' => \request()->ip(),
                ]);
                if (!$g_response->json('success')){
                    $fail('The {$attribute} is invalid');
                }
            }],
        ];
    }
}
