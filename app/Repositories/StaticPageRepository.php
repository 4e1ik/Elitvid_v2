<?php

namespace App\Repositories;

use App\Models\StaticPage;

class StaticPageRepository
{
    public function getAllStaticPages()
    {
        return StaticPage::where('active', 1)->get();
    }
}
