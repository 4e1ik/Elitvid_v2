<?php

namespace App\Services\Admin;

use App\Models\StaticPage;
use App\Models\StaticPageGallery;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;

class StaticPageService
{
    public function __construct(
        public ImageService $imageService,
    ){}

    public function store(array $data): StaticPage
    {
        return DB::transaction(function () use ($data) {
            // Обработка active
            $data['active'] = isset($data['active']) && ($data['active'] == '1' || $data['active'] === true);

            // Автогенерация slug из title, если slug пустой
            if (empty($data['slug']) && !empty($data['title'])) {
                $data['slug'] = $this->generateSlug($data['title']);
            }

            $staticPage = StaticPage::create($data);

            // Обработка главной картинки
            if (isset($data['main_image']) && $data['main_image']) {
                $this->imageService->save(
                    images: [$data['main_image']],
                    model: $staticPage,
                    imageData: [[
                        'main_image' => true,
                        'menu_image' => false,
                        'description_image' => $data['main_image_description'] ?? null,
                    ]]
                );
            }

            // Обработка картинки меню
            if (isset($data['menu_image']) && $data['menu_image']) {
                $this->imageService->save(
                    images: [$data['menu_image']],
                    model: $staticPage,
                    imageData: [[
                        'main_image' => false,
                        'menu_image' => true,
                        'description_image' => $data['menu_image_description'] ?? null,
                    ]]
                );
            }

            // Обработка галереи
            if (isset($data['gallery_images']) && !empty($data['gallery_images'])) {
                $galleryDescriptions = $data['gallery_descriptions'] ?? [];
                
                // Обработка active для галереи
                $galleryActive = isset($data['gallery_active']) && ($data['gallery_active'] == '1' || $data['gallery_active'] === true);
                
                // Создаем галерею для статической страницы
                $gallery = StaticPageGallery::create([
                    'static_galleriable_id' => $staticPage->id,
                    'static_galleriable_type' => StaticPage::class,
                    'active' => $galleryActive,
                ]);

                // Сохраняем изображения в галерею
                $this->imageService->save(
                    images: $data['gallery_images'],
                    model: $gallery,
                    imageData: array_map(function($index) use ($galleryDescriptions) {
                        return [
                            'description_image' => $galleryDescriptions[$index] ?? null,
                            'main_image' => false,
                        ];
                    }, array_keys($data['gallery_images']))
                );
            }

            return $staticPage;
        });
    }

    public function update(array $data, StaticPage $staticPage): StaticPage
    {
        return DB::transaction(function () use ($data, $staticPage) {
            // Обработка active
            $data['active'] = isset($data['active']) && ($data['active'] == '1' || $data['active'] === true);

            $staticPage->update($data);

            // Обработка новой главной картинки
            if (isset($data['main_image']) && $data['main_image']) {
                // Удаляем старую главную картинку
                $oldMainImage = $staticPage->images()->where('main_image', true)->first();
                if ($oldMainImage) {
                    $this->imageService->delete($oldMainImage);
                }

                // Сохраняем новую главную картинку
                $this->imageService->save(
                    images: [$data['main_image']],
                    model: $staticPage,
                    imageData: [[
                        'main_image' => true,
                        'menu_image' => false,
                        'description_image' => $data['main_image_description'] ?? null,
                    ]]
                );
            }

            // Обработка новой картинки меню
            if (isset($data['menu_image']) && $data['menu_image']) {
                // Удаляем старую картинку меню
                $oldMenuImage = $staticPage->images()->where('menu_image', true)->first();
                if ($oldMenuImage) {
                    $this->imageService->delete($oldMenuImage);
                }

                // Сохраняем новую картинку меню
                $this->imageService->save(
                    images: [$data['menu_image']],
                    model: $staticPage,
                    imageData: [[
                        'main_image' => false,
                        'menu_image' => true,
                        'description_image' => $data['menu_image_description'] ?? null,
                    ]]
                );
            }

            // Обработка новых изображений галереи
            if (isset($data['gallery_images']) && !empty($data['gallery_images'])) {
                $galleryDescriptions = $data['gallery_descriptions'] ?? [];
                
                // Обработка active для галереи
                $galleryActive = isset($data['gallery_active']) && ($data['gallery_active'] == '1' || $data['gallery_active'] === true);
                
                // Получаем или создаем галерею
                $gallery = StaticPageGallery::firstOrCreate([
                    'static_galleriable_id' => $staticPage->id,
                    'static_galleriable_type' => StaticPage::class,
                ], [
                    'active' => $galleryActive,
                ]);
                
                // Обновляем active, если галерея уже существовала
                if ($gallery->wasRecentlyCreated === false) {
                    $gallery->update(['active' => $galleryActive]);
                }

                // Сохраняем новые изображения в галерею
                $this->imageService->save(
                    images: $data['gallery_images'],
                    model: $gallery,
                    imageData: array_map(function($index) use ($galleryDescriptions) {
                        return [
                            'description_image' => $galleryDescriptions[$index] ?? null,
                            'main_image' => false,
                        ];
                    }, array_keys($data['gallery_images']))
                );
            }

            return $staticPage;
        });
    }

    public function destroy(StaticPage $staticPage): bool
    {
        return DB::transaction(function () use ($staticPage) {
            // Удаляем все изображения
            foreach ($staticPage->images as $image) {
                $this->imageService->delete($image);
            }

            // Удаляем галереи и их изображения
            foreach ($staticPage->static_gallery as $gallery) {
                foreach ($gallery->images as $image) {
                    $this->imageService->delete($image);
                }
                $gallery->delete();
            }

            return $staticPage->delete();
        });
    }

    /**
     * Генерация slug из русского текста
     */
    private function generateSlug(string $text): string
    {
        $translitMap = [
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
            'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm',
            'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo',
            'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M',
            'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'H', 'Ц' => 'Ts', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
            'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
        ];

        $slug = mb_strtolower($text, 'UTF-8');
        $slug = strtr($slug, $translitMap);
        $slug = preg_replace('/[^a-z0-9]+/', '_', $slug);
        $slug = trim($slug, '_');

        return $slug;
    }
}
