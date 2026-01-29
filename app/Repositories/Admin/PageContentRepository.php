<?php

namespace App\Repositories\Admin;

use App\Models\PageContent;

class PageContentRepository
{
    public function getAllPages()
    {
        return PageContent::with('gallery')->get();

    }

    public function getPageContentById($id)
    {
        return PageContent::where('id', $id)->with('gallery.images')->first();
    }
}
