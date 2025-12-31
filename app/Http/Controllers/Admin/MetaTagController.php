<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MetaTagRequest;
use App\Models\MetaTag;

class MetaTagController extends Controller
{
    public function update(MetaTagRequest $request, MetaTag $metaTag)
    {
        $data = $request->all();
        $metaTag->fill($data)->save();
        return back();
    }
}
