<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ProductRouteCreatingHelper;
use App\Helpers\WebResponse;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\Admin\ProductService;
use App\Services\ImageService;

class ProductController
{
    public function __construct(
        public ImageService $imageService,
        public ProductService $productService,

        public ProductRouteCreatingHelper $productRouteCreatingHelper,
    ){}

    public function store(CreateProductRequest $request)
    {
        try {
            $data = $request->all();
            $product = $this->productService->store($data);
            $route = $this->productRouteCreatingHelper->route($product);
            return WebResponse::success(redirect($route ?? route('products.edit', ['product' => $product])));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function edit(Product $product)
    {
        try {
            $product->load(['pot', 'bench', 'images']);
            $productType = $product->product_type;
            if (!$productType) {
                abort(404, 'Тип продукта не определен');
            }
            return WebResponse::success(view('includes.elitvid.admin.update_product', compact('product', 'productType')));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $data = $request->all();
            $product = $this->productService->update(data: $data, product: $product);
            $route = $this->productRouteCreatingHelper->route($product);
            return WebResponse::success(redirect($route ?? route('products.edit', ['product' => $product])));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function destroy(Product $product)
    {
        try {
            $route = $this->productRouteCreatingHelper->route($product);
            $this->productService->destroy(product: $product);
            return WebResponse::success(redirect($route ?? route('admin'))
                ->with('success', 'Товар успешно удален'));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }
}
