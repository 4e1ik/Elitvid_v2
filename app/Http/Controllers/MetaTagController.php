<?php

namespace App\Http\Controllers;

use App\Http\Requests\MetaTagRequest;
use App\Models\MetaTag;
use Illuminate\Http\Request;

class MetaTagController extends Controller
{
    public function update(MetaTagRequest $request, MetaTag $metaTag)
    {
        $data = $request->all();
//        dd($data);
        $metaTag->fill($data)->save();
        return back();
    }
}
