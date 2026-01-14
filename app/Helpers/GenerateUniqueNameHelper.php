<?php

namespace App\Helpers;

use Illuminate\Contracts\Filesystem\Filesystem;

final class GenerateUniqueNameHelper
{
    public function generateUniqueName(string $originalName, Filesystem $disk, string $folder)
    {
        $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);

        $fileName = $nameWithoutExtension . '.' . $extension;
        $filePath = $folder . '/' . $fileName;

        // Если файл не существует, возвращаем оригинальное имя
        if (!$disk->exists($filePath)) {
            return $fileName;
        }

        // Если существует, добавляем постфикс
        $counter = 1;
        do {
            $fileName = $nameWithoutExtension . '(' . $counter . ').' . $extension;
            $filePath = $folder . '/' . $fileName;
            $counter++;
        } while ($disk->exists($filePath));

        return $fileName;
    }
}
