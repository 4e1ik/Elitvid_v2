<?php

namespace App\Repositories\Admin;

use App\Models\MetaTag;

class MetaTagRepository
{
    public function getMetaTags()
    {
        return MetaTag::all();
    }
}
