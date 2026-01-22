<?php

namespace App\Repositories\Admin;

use App\Models\StaticPage;

class StaticPageRepository
{
    public function getAll()
    {
        return StaticPage::with(['images', 'galleries.images'])
            ->latest()
            ->get();
    }

    public function getBySlug(string $slug)
    {
        return StaticPage::with(['images', 'galleries.images'])
            ->where('slug', $slug)
            ->first();
    }

    public function getById(int $id)
    {
        return StaticPage::with(['images', 'galleries.images'])
            ->findOrFail($id);
    }
}
