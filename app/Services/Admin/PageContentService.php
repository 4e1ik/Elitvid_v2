<?php

namespace App\Services\Admin;

use App\Models\Gallery;
use App\Models\PageContent;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;

class PageContentService
{
    public function __construct(
        public ImageService $imageService
    ){}

    public function update(array $data, PageContent $pageContent)
    {
        return DB::transaction(function () use ($data, $pageContent) {
//            dd();
            $pageContent->update($data);
            $gallery = $pageContent->gallery;
            if (!$gallery) {
                $gallery = Gallery::create([
                    'type' => $pageContent->page,
                    'galleriable_id' => $pageContent->id,
                    'galleriable_type' => PageContent::class,
                    'active' => 1,
                ]);
            } else {
                if (!isset($data['active'])) $data['active'] = 0;
                $gallery->update($data);
            }

            if (isset($data['gallery_images'], $data)) {
                $this->imageService->save(
                    images: $data['gallery_images'], model: $gallery, imageData: $data['gallery_descriptions']
                );
            }
        });
    }
}
