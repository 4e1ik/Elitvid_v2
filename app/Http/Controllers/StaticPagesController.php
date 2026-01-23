<?php

namespace App\Http\Controllers;

use App\Models\StaticPage;

class StaticPagesController
{
    public function index(string $slug)
    {
        $staticPage = StaticPage::where('slug', $slug)->first();
        $static_pages = StaticPage::all();
        return view('elitvid.site.static_page', compact('staticPage', 'static_pages'));
    }
}
