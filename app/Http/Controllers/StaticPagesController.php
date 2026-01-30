<?php

namespace App\Http\Controllers;

use App\Helpers\WebResponse;
use App\Models\StaticPage;

class StaticPagesController
{
    public function index(string $slug)
    {
        try {
            $pageContent = StaticPage::where('slug', $slug)->first();
            $static_pages = StaticPage::all();
            return WebResponse::success(view('elitvid.site.static_page', compact('pageContent', 'static_pages')));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }
}
