<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ProductRouteCreatingHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateImageRequest;
use App\Models\Image;
use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function __construct(
        public ImageService $imageService,
        public ProductRouteCreatingHelper $productRouteCreatingHelper
    ){}

    public function update(UpdateImageRequest $request, Image $image, Product $product)
    {
        $data = $request->all();

        $this->imageService->update(image: $image, data: $data);

        return redirect(route('products.edit', ['product' => $product]))
            ->with('success', 'Изображение успешно обновлено');
    }

    public function destroy(Image $image, Product $product)
    {
        $this->imageService->delete(image: $image);

        return redirect(route('products.edit', ['product' => $product]))
            ->with('success', 'Изображение успешно удалено');
    }
}
