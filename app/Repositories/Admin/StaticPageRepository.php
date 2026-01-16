<?php

namespace App\Repositories\Admin;

use App\Models\StaticPage;

class StaticPageRepository
{
    public function getAll()
    {
        return StaticPage::with(['images', 'static_gallery.images'])
            ->latest()
            ->get();
    }

    public function getBySlug(string $slug)
    {
        return StaticPage::with(['images', 'static_gallery.images'])
            ->where('slug', $slug)
            ->first();
    }

    public function getById(int $id)
    {
        return StaticPage::with(['images', 'static_gallery.images'])
            ->findOrFail($id);
    }
}
