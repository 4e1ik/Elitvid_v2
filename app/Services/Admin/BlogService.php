<?php

namespace App\Services\Admin;

use App\Models\Blog;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BlogService
{
    public function __construct(
        public ImageService $imageService,
    ){}

    public function create(array $data)
    {
        DB::transaction(function () use ($data) {
            $blog = Blog::create($data);

            // Сохраняем главное изображение через ImageService
            if (isset($data['main_image'])) {
                $this->imageService->save(
                    images: [$data['main_image']],
                    model: $blog,
                    imageData: [[
                        'main_image' => true,
                        'menu_image' => false,
                    ]]
                );
            }
        });
    }

    public function update(array $data, Blog $blog)
    {
        return DB::transaction(function () use ($data, $blog) {
            $blog->update($data);

            if (isset($data['main_image'])) {
                $oldMainImage = $blog->images()->where('main_image', true)->first();
                if ($oldMainImage) {
                    $this->imageService->delete($oldMainImage);
                }

                $this->imageService->save(
                    images: [$data['main_image']],
                    model: $blog,
                    imageData: [[
                        'main_image' => true,
                        'menu_image' => false,
                    ]]
                );
            }
        });
    }

    public function delete(Blog $blog)
    {
        return DB::transaction(function () use ($blog) {
            foreach ($blog->images as $image) {
                $this->imageService->delete($image);
            }

            // Удаляем старое изображение, если оно хранится в поле main_image (для обратной совместимости)
            if ($blog->main_image) {
                Storage::delete($blog->main_image);
            }

            $blog->delete();
        });
    }
}
