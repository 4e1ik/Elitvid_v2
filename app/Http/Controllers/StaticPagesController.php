<?php

namespace App\Http\Controllers;

use App\Models\StaticPage;

class StaticPagesController
{
    public function index(string $slug)
    {
        $static_page = StaticPage::where('slug', $slug)->first();
        return view('static_page', compact('static_page'));
    }
}
