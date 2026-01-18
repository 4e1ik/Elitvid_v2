<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ProductRouteCreatingHelper;
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
        $data = $request->all();

        $product = $this->productService->store($data);

        $route = $this->productRouteCreatingHelper->route($product);

        return redirect($route ?? route('products.edit', ['product' => $product]));
    }

    public function edit(Product $product)
    {
        $product->load(['pot', 'bench', 'images']);

        $productType = $product->product_type;

        if (!$productType) {
            abort(404, 'Тип продукта не определен');
        }

        return view('includes.elitvid.admin.update_product', compact('product', 'productType'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->all();

        $product = $this->productService->update(data: $data, product: $product);

        $route = $this->productRouteCreatingHelper->route($product);

        return redirect($route ?? route('products.edit', ['product' => $product]));
        }

    public function destroy(Product $product)
    {
        $route = $this->productRouteCreatingHelper->route($product);

        $this->productService->destroy(product: $product);

        return redirect($route ?? route('admin'))
            ->with('success', 'Товар успешно удален');
    }
}
