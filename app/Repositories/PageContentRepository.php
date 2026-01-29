<?php

namespace App\Repositories;

use App\Models\PageContent;

class PageContentRepository
{
    public function getPageContent(string $page)
    {
        return PageContent::where('page', $page)->with(['gallery'])->first();
    }
}
