<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class UploadedImageRule implements ValidationRule
{
    /**
     * Единое правило валидации загружаемых изображений (включая HEIC/HEIF).
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var UploadedFile|null $file */
        $file = $value instanceof UploadedFile ? $value : null;

        if ($file === null) {
            $fail('Файл загружен некорректно.');
            return;
        }

        if (! $file->isValid()) {
            $fail('Файл невалиден или не был загружен корректно.');
            return;
        }

        $maxSize = 10 * 1024 * 1024; // 10MB
        if ($file->getSize() > $maxSize) {
            $fail('Файл превышает 10 МБ.');
            return;
        }

        $allowedMimes = [
            'image/jpeg',
            'image/png',
            'image/webp',
            'image/heic',
            'image/heif',
            'image/heic-sequence',
            'image/heif-sequence',
            'image/x-heic',
            'image/x-heif',
        ];

        $mimeType = $file->getMimeType();
        if (! in_array($mimeType, $allowedMimes, true)) {
            $fail('Изображение должно быть в формате: jpeg, png, webp или heic.');
            return;
        }
    }
}

