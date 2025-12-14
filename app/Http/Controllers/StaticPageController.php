<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaticPageRequest;
use App\Models\StaticPage;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class StaticPageController extends Controller
{
    public function index()
    {
        $staticPages = StaticPage::latest()->get();
        return view('elitvid.admin.static_pages.index', compact('staticPages'));
    }

    public function edit(StaticPage $staticPage)
    {
        return view('elitvid.admin.static_pages.edit', compact('staticPage'));
    }

    public function update(StaticPageRequest $request, StaticPage $staticPage)
    {
        $data = $request->validated();

        if ($request->hasFile('main_image')) {
            // Удаляем старое изображение
            if ($staticPage->main_image && Storage::exists(str_replace('storage/', 'public/', $staticPage->main_image))) {
                Storage::delete(str_replace('storage/', 'public/', $staticPage->main_image));
            }

            $file = $request->file('main_image');
            $extension = $file->getClientOriginalExtension();
            $name = hash('md5', $file->getClientOriginalName()) . '.webp';
            
            // Конвертация в WebP
            try {
                ImageManager::gd()
                    ->read($file)
                    ->toWebp(90)
                    ->save(storage_path('app/public/images/' . $name));
                
                $data['main_image'] = 'storage/images/' . $name;
            } catch (\Exception $e) {
                // Если WebP не поддерживается, сохраняем оригинал
                $name = hash('md5', $file->getClientOriginalName()) . '.' . $extension;
                Storage::putFileAs('public/images', $file, $name);
                $data['main_image'] = 'storage/images/' . $name;
            }
        }

        $staticPage->update($data);
        return redirect()->route('static_pages.index')->with('success', 'Страница успешно обновлена');
    }

    public function destroy(StaticPage $staticPage)
    {
        if ($staticPage->main_image && Storage::exists(str_replace('storage/', 'public/', $staticPage->main_image))) {
            Storage::delete(str_replace('storage/', 'public/', $staticPage->main_image));
        }

        $staticPage->delete();
        return redirect()->route('static_pages.index')->with('success', 'Страница успешно удалена');
    }
}

