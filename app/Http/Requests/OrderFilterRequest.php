<?php

namespace App\Http\Requests;

use App\DTO\OrderFilterData;
use Illuminate\Foundation\Http\FormRequest;

class OrderFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date_from' => 'nullable|date_format:Y-m-d',
            'date_to' => 'nullable|date_format:Y-m-d',
        ];
    }

    public function toData(): OrderFilterData
    {
        return new OrderFilterData(
            from: $this->input('date_from'),
            to: $this->input('date_to'),
        );
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'date_from' => $this->input('date_from') ?: null,
            'date_to' => $this->input('date_to') ?: null,
        ]);
    }
}
