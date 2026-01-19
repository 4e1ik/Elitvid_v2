<?php

namespace App\Console\Commands;

use App\Helpers\GenerateUniqueNameHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class ConvertImagesToWebP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:convert-to-webp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert all images from images and static_images tables to WebP format';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting image conversion to WebP...');

        $convertedCount = 0;
        $skippedCount = 0;
        $errorCount = 0;
        $errorDetails = [];

        // Конвертация изображений из таблицы images
        $this->info('Processing images table...');
        $result = $this->convertImagesTable($errorDetails);
        $convertedCount += $result['converted'];
        $skippedCount += $result['skipped'];
        $errorCount += $result['errors'];

        // Конвертация изображений из таблицы static_images
        $this->info('Processing static_images table...');
        $result = $this->convertStaticImagesTable($errorDetails);
        $convertedCount += $result['converted'];
        $skippedCount += $result['skipped'];
        $errorCount += $result['errors'];

        $this->info("Conversion completed!");
        $this->info("Converted: {$convertedCount}");
        $this->info("Skipped (already WebP): {$skippedCount}");
        $this->info("Errors: {$errorCount}");

        // Выводим детали ошибок, если они есть
        if (!empty($errorDetails)) {
            $this->newLine();
            $this->error("Error details:");
            foreach ($errorDetails as $error) {
                $this->line("  - {$error}");
            }
        }

        return 0;
    }

    /**
     * Конвертация изображений из таблицы images
     */
    private function convertImagesTable(array &$errorDetails): array
    {
        $converted = 0;
        $skipped = 0;
        $errors = 0;

        $images = DB::table('images')->get();
        $total = $images->count();
        $this->info("Found {$total} images in images table");

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        foreach ($images as $image) {
            try {
                $errorMessage = '';
                $result = $this->convertImage($image->image, 'images', $image->id, $errorMessage);
                if ($result === 'converted') {
                    $converted++;
                } elseif ($result === 'skipped') {
                    $skipped++;
                } else {
                    $errors++;
                    if (!empty($errorMessage)) {
                        $errorDetails[] = "images table, ID {$image->id}: {$errorMessage}";
                    }
                }
            } catch (\Exception $e) {
                $errors++;
                $errorDetails[] = "images table, ID {$image->id}: " . $e->getMessage();
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        return ['converted' => $converted, 'skipped' => $skipped, 'errors' => $errors];
    }

    /**
     * Конвертация изображений из таблицы static_images
     */
    private function convertStaticImagesTable(array &$errorDetails): array
    {
        $converted = 0;
        $skipped = 0;
        $errors = 0;

        $staticImages = DB::table('static_images')->get();
        $total = $staticImages->count();
        $this->info("Found {$total} images in static_images table");

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        foreach ($staticImages as $staticImage) {
            try {
                $errorMessage = '';
                $result = $this->convertImage($staticImage->image, 'static_images', $staticImage->id, $errorMessage);
                if ($result === 'converted') {
                    $converted++;
                } elseif ($result === 'skipped') {
                    $skipped++;
                } else {
                    $errors++;
                    if (!empty($errorMessage)) {
                        $errorDetails[] = "static_images table, ID {$staticImage->id}: {$errorMessage}";
                    }
                }
            } catch (\Exception $e) {
                $errors++;
                $errorDetails[] = "static_images table, ID {$staticImage->id}: " . $e->getMessage();
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        return ['converted' => $converted, 'skipped' => $skipped, 'errors' => $errors];
    }

    /**
     * Конвертация одного изображения
     * 
     * @param string $imagePath Путь к изображению из БД
     * @param string $tableName Имя таблицы для обновления
     * @param int $recordId ID записи
     * @param string &$errorMessage Сообщение об ошибке (если есть)
     * @return string 'converted', 'skipped' или 'error'
     */
    private function convertImage(string $imagePath, string $tableName, int $recordId, string &$errorMessage = ''): string
    {
        if (empty($imagePath)) {
            $errorMessage = "Empty image path";
            return 'error';
        }

        $interventionManager = ImageManager::gd();

        // Определяем, где находится файл: в public/ или в storage/app/public/
        $normalizedPath = ltrim($imagePath, '/');
        $isPublicPath = str_starts_with($normalizedPath, 'elitvid_assets/');
        
        $fullPath = null;
        $storagePath = null;
        $newFullPath = null;
        
        if ($isPublicPath) {
            // Файл находится в public/elitvid_assets/...
            $fullPath = public_path($normalizedPath);
            $storagePath = $normalizedPath;
        } else {
            // Файл находится в storage/app/public/...
            $disk = Storage::disk('public');
            
            // Если путь начинается с "public/", убираем его
            $storagePath = str_replace('public/', '', $imagePath);
            $storagePath = ltrim($storagePath, '/');
            
            $fullPath = $disk->path($storagePath);
        }
        
        // Получаем расширение файла из пути
        $extension = strtolower(pathinfo($storagePath, PATHINFO_EXTENSION));
        
        // Если уже WebP, проверяем существование и пропускаем
        if ($extension === 'webp') {
            if (file_exists($fullPath)) {
                return 'skipped';
            } else {
                // Пытаемся найти файл с похожим именем в той же папке
                $pathInfo = pathinfo($storagePath);
                $directory = $pathInfo['dirname'] !== '.' ? $pathInfo['dirname'] : '';
                $nameWithoutExtension = $pathInfo['filename'];
                $dirPath = $isPublicPath 
                    ? public_path($directory !== '' ? $directory : '.')
                    : ($directory !== '' ? Storage::disk('public')->path($directory) : Storage::disk('public')->path('.'));
                
                if (is_dir($dirPath)) {
                    $files = scandir($dirPath);
                    $foundFile = null;
                    
                    // Ищем файл, который содержит имя исходного файла
                    foreach ($files as $file) {
                        if ($file !== '.' && $file !== '..' && 
                            str_contains(strtolower($file), strtolower($nameWithoutExtension)) && 
                            str_ends_with(strtolower($file), '.webp')) {
                            $foundFile = $file;
                            break;
                        }
                    }
                    
                    if ($foundFile) {
                        // Обновляем путь в БД на найденный файл
                        $newPath = $directory !== '' ? $directory . '/' . $foundFile : $foundFile;
                        $newDbPath = str_starts_with($imagePath, '/') 
                            ? '/' . $newPath 
                            : ($isPublicPath ? $newPath : (str_starts_with($imagePath, 'public/') ? 'public/' . $newPath : $newPath));
                        
                        try {
                            DB::table($tableName)
                                ->where('id', $recordId)
                                ->update(['image' => $newDbPath]);
                            return 'skipped'; // Обновили путь на похожий файл
                        } catch (\Exception $e) {
                            $errorMessage = "WebP file not found and cannot update DB: {$fullPath} - " . $e->getMessage();
                            return 'error';
                        }
                    }
                }
                
                $errorMessage = "WebP file not found: {$fullPath} (DB path: {$imagePath})";
                return 'error';
            }
        }
        
        // Проверяем, существует ли файл
        if (!file_exists($fullPath)) {
            // Если файл не найден, проверяем, может быть уже есть .webp версия
            $pathInfo = pathinfo($storagePath);
            $directory = $pathInfo['dirname'] !== '.' ? $pathInfo['dirname'] : '';
            $nameWithoutExtension = $pathInfo['filename'];
            
            $webpPath = !empty($directory) 
                ? $directory . '/' . $nameWithoutExtension . '.webp'
                : $nameWithoutExtension . '.webp';
            
            $webpFullPath = $isPublicPath 
                ? public_path($webpPath)
                : Storage::disk('public')->path($webpPath);
            
            // Если .webp версия существует, обновляем путь в БД
            if (file_exists($webpFullPath)) {
                $newDbPath = str_starts_with($imagePath, '/') 
                    ? '/' . $webpPath 
                    : ($isPublicPath ? $webpPath : (str_starts_with($imagePath, 'public/') ? 'public/' . $webpPath : $webpPath));
                
                try {
                    DB::table($tableName)
                        ->where('id', $recordId)
                        ->update(['image' => $newDbPath]);
                    return 'skipped'; // Уже конвертирован, просто обновили путь
                } catch (\Exception $e) {
                    $errorMessage = "File not found and cannot update DB path: {$fullPath} - " . $e->getMessage();
                    return 'error';
                }
            }
            
            $errorMessage = "File not found: {$fullPath} (DB path: {$imagePath})";
            return 'error';
        }

        // Читаем файл
        try {
            $item = $interventionManager->read($fullPath);
        } catch (\Exception $e) {
            $errorMessage = "Cannot read image: {$fullPath} - " . $e->getMessage();
            return 'error';
        }

        // Сохраняем исходную структуру папок и имя файла, меняем только расширение
        $pathInfo = pathinfo($storagePath);
        $directory = $pathInfo['dirname'] !== '.' ? $pathInfo['dirname'] : '';
        $nameWithoutExtension = $pathInfo['filename'];
        
        // Формируем новый путь с тем же именем, но с расширением .webp
        $newPath = !empty($directory) 
            ? $directory . '/' . $nameWithoutExtension . '.webp'
            : $nameWithoutExtension . '.webp';

        // Конвертируем в WebP
        try {
            $convertedImage = $item->toWebp(100);
        } catch (\Exception $e) {
            $errorMessage = "Cannot convert to WebP: {$storagePath} - " . $e->getMessage();
            return 'error';
        }

        // Сохраняем новый файл
        if ($isPublicPath) {
            // Сохраняем в public/
            $newFullPath = public_path($newPath);
            $newDir = dirname($newFullPath);
            if (!is_dir($newDir)) {
                mkdir($newDir, 0755, true);
            }
            file_put_contents($newFullPath, $convertedImage);
        } else {
            // Сохраняем в storage/app/public/
            $disk = Storage::disk('public');
            try {
                $disk->put($newPath, $convertedImage);
            } catch (\Exception $e) {
                $errorMessage = "Cannot save converted file: {$newPath} - " . $e->getMessage();
                return 'error';
            }
        }

        // Обновляем путь в БД, сохраняя исходный формат
        $newDbPath = str_starts_with($imagePath, '/') 
            ? '/' . $newPath 
            : ($isPublicPath ? $newPath : (str_starts_with($imagePath, 'public/') ? 'public/' . $newPath : $newPath));
            
        try {
            DB::table($tableName)
                ->where('id', $recordId)
                ->update(['image' => $newDbPath]);
        } catch (\Exception $e) {
            $errorMessage = "Cannot update database: " . $e->getMessage();
            return 'error';
        }

        // Удаляем старый файл только если новый файл имеет другое имя
        if ($storagePath !== $newPath && file_exists($fullPath)) {
            try {
                unlink($fullPath);
            } catch (\Exception $e) {
                // Не считаем это критической ошибкой, файл уже конвертирован
            }
        }

        return 'converted';
    }
}
