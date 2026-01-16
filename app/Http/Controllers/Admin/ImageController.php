<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ProductRouteCreatingHelper;
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
        $data = $request->all();

        $this->imageService->update(image: $image, data: $data);

        // Получаем связанную модель через полиморфную связь
        $model = $image->imageable;
        
        if ($model instanceof Product) {
            return redirect(route('products.edit', ['product' => $model]))
                ->with('success', 'Изображение успешно обновлено');
        } elseif ($model instanceof StaticPage) {
            return redirect(route('static_pages.edit', ['static_page' => $model]))
                ->with('success', 'Изображение успешно обновлено');
        }

        return redirect()->back()
            ->with('success', 'Изображение успешно обновлено');
    }

    public function destroy(Image $image)
    {
        // Получаем связанную модель через полиморфную связь перед удалением
        $model = $image->imageable;
        
        $this->imageService->delete(image: $image);

        if ($model instanceof Product) {
            $route = $this->productRouteCreatingHelper->route($model);
            return redirect($route ?? route('products.edit', ['product' => $model]))
                ->with('success', 'Изображение успешно удалено');
        } elseif ($model instanceof StaticPage) {
            return redirect(route('static_pages.edit', ['static_page' => $model]))
                ->with('success', 'Изображение успешно удалено');
        }

        return redirect()->back()
            ->with('success', 'Изображение успешно удалено');
    }
}
