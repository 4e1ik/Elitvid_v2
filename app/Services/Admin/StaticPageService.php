<?php

namespace App\Services\Admin;

use App\Helpers\SlugGenerateHelper;
use App\Models\StaticPage;
use App\Models\Gallery;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;

class StaticPageService
{
    public function __construct(
        public ImageService $imageService,
        public SlugGenerateHelper $slugGenerateHelper
    ){}

    public function store(array $data): StaticPage
    {
        return DB::transaction(function () use ($data) {

            if (empty($data['slug']) && !empty($data['title'])) {
                $data['slug'] = $this->slugGenerateHelper->slug($data['title']);
            }

            $staticPage = StaticPage::create($data);

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

            // Обработка active для галереи
            $galleryActive = isset($data['gallery_active']) && ($data['gallery_active'] == '1' || $data['gallery_active'] === true);

            // Обработка новых изображений галереи
            if (isset($data['gallery_images']) && !empty($data['gallery_images'])) {
                $galleryDescriptions = $data['gallery_descriptions'] ?? [];

                // Создаем галерею через полиморфную связь
                $gallery = Gallery::create([
                    'galleriable_id' => $staticPage->id,
                    'galleriable_type' => StaticPage::class,
                    'active' => $galleryActive,
                ]);

                // Сохраняем изображения в Gallery
                $this->imageService->save(
                    images: $data['gallery_images'],
                    model: $gallery,
                    imageData: array_map(function($index) use ($galleryDescriptions) {
                        return [
                            'description_image' => $galleryDescriptions[$index] ?? null,
                            'main_image' => false,
                            'menu_image' => false,
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
            // active уже обработан в контроллере, просто приводим к boolean для гарантии

            // Генерируем slug, если он пустой и есть title (такая же логика, как при создании)
            if (empty($data['slug']) && !empty($data['title'])) {
                $data['slug'] = $this->slugGenerateHelper->slug($data['title']);
            }

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

            // Обработка active для галереи (даже если не добавляются новые изображения)
            $galleryActive = isset($data['gallery_active']) && ($data['gallery_active'] == '1' || $data['gallery_active'] === true);
            $gallery = $staticPage->gallery;
            
            if ($gallery) {
                // Обновляем active для существующей галереи
                $gallery->update(['active' => $galleryActive]);
            }

            // Обработка новых изображений галереи
            if (isset($data['gallery_images']) && !empty($data['gallery_images'])) {
                $galleryDescriptions = $data['gallery_descriptions'] ?? [];

                // Получаем или создаем галерею через полиморфную связь
                if (!$gallery) {
                    $gallery = Gallery::create([
                        'galleriable_id' => $staticPage->id,
                        'galleriable_type' => StaticPage::class,
                        'active' => $galleryActive,
                    ]);
                }

                // Сохраняем новые изображения в Gallery
                $this->imageService->save(
                    images: $data['gallery_images'],
                    model: $gallery,
                    imageData: array_map(function($index) use ($galleryDescriptions) {
                        return [
                            'description_image' => $galleryDescriptions[$index] ?? null,
                            'main_image' => false,
                            'menu_image' => false,
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

            // Удаляем галерею и её изображения (одна галерея на страницу)
            $gallery = $staticPage->gallery;
            if ($gallery) {
                // Удаляем все изображения галереи
                foreach ($gallery->images as $image) {
                    $this->imageService->delete($image);
                }
                $gallery->delete();
            }

            return $staticPage->delete();
        });
    }

}
