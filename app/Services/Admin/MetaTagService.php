<?php

namespace App\Services\Admin;

use App\Models\MetaTag;
use Illuminate\Support\Facades\DB;

class MetaTagService
{
    public function update(array $data, MetaTag $metaTag)
    {
        return DB::transaction(function () use ($data, $metaTag) {
            return $metaTag->fill($data)->save();
        });
    }
}
