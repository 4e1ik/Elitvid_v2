<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\StaticImages;

class ParseStaticImages extends Command
{
    protected $signature = 'parse:static-images';
    protected $description = 'Парсит пути к статичным изображениям из Blade шаблонов и сохраняет их в базу';

    public function handle(): void
    {
        $this->info("\ud83d\udcc2 Scanning directory: resources/views/elitvid/site");

        $bladePath = resource_path('views/elitvid/site');
        $files = File::allFiles($bladePath);

        $this->info("\ud83d\udcc4 Found " . count($files) . " files");

        foreach ($files as $file) {
            $viewPath = $file->getPathname();
            $viewName = str_replace([resource_path('views') . '/', '.blade.php'], '', $viewPath);
            $segments = explode('/', $viewName);
            $shortView = array_pop($segments);

            // Если есть дубли имен view, сохраняем полное имя
            static $seen = [];
            if (in_array($shortView, $seen)) {
                $page = str_replace('/', '.', $viewName);
            } else {
                $page = $shortView;
                $seen[] = $shortView;
            }

            $this->processImages($file->getContents(), $page);
        }

        $this->info("\u2705 Static images parsed successfully!");
    }

    private function processImages(string $content, string $page): void
    {
        // Ищем src="{{ asset('...') }}"
        $pattern = '/<img[^>]+src\s*=\s*["\']\s*\{\{\s*asset\((.*?)\)\s*\}\}\s*["\']/i';
        preg_match_all($pattern, $content, $matches);

        foreach ($matches[1] as $rawPath) {
            $path = trim($rawPath, '\'" ');

            // Фильтрация путей, только те, что содержат newDesign/imgs/
            if (str_contains($path, 'newDesign/newDesign/imgs/')) {
                $this->updateDatabase($path, $page);
            }
        }
    }

    private function updateDatabase(string $imagePath, string $page): void
    {
        $existing = StaticImages::where('image', $imagePath)->where('page', $page)->first();

        if (!$existing) {
            StaticImages::create([
                'image' => $imagePath,
                'description_image' => null,
                'page' => $page,
            ]);
            $this->info("\ud83d\udcc2 Inserted: $imagePath (page: $page)");
        } else {
            $this->line("\ud83d\udd01 Already exists: $imagePath (page: $page)");
        }
    }
}
