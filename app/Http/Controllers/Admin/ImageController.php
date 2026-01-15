<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function update(Request $request, Image $image)
    {
        $data = $request->validate([
            'description_image' => 'nullable|string|max:5000',
            'color' => 'nullable|string|max:255',
            'texture' => 'nullable|string|max:255',
        ]);

        $image->update($data);

        // Получаем продукт для редиректа
        $product = $image->imageable;
        
        if ($product && method_exists($product, 'pot')) {
            return redirect()->route('products.edit', ['product' => $product])->with('success', 'Изображение успешно обновлено');
        }

        return back()->with('success', 'Изображение успешно обновлено');
    }

    public function destroy(Image $image)
    {
        // Удаляем файл изображения
        // Путь в БД: 'public/images/filename.webp'
        // Для Storage::disk('public') нужно использовать путь без 'public/'
        if ($image->image) {
            $path = str_replace('public/', '', $image->image);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        // Получаем продукт для редиректа
        $product = $image->imageable;
        
        $image->delete();

        if ($product && method_exists($product, 'pot')) {
            return redirect()->route('products.edit', ['product' => $product])->with('success', 'Изображение успешно удалено');
        }

        return back()->with('success', 'Изображение успешно удалено');
    }
}
