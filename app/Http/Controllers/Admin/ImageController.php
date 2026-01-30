<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ProductRouteCreatingHelper;
use App\Helpers\WebResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateImageRequest;
use App\Models\Image;
use App\Models\Product;
use App\Models\StaticPage;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function __construct(
        public ImageService $imageService,
        public ProductRouteCreatingHelper $productRouteCreatingHelper
    ){}

    public function update(UpdateImageRequest $request, Image $image)
    {
        try {
            $this->imageService->update(image: $image, data: $request->all());
            return WebResponse::success(redirect()->back()
                ->with('success', 'Изображение успешно обновлено'));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function destroy(Request $request, Image $image)
    {
        try {
            $this->imageService->delete(image: $image);
            return WebResponse::success(redirect()->back()
                ->with('success', 'Изображение успешно удалено'));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }
}
