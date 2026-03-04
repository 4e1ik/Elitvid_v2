<?php

namespace App\Http\Controllers;

use App\Helpers\WebResponse;
use App\Models\StaticPage;
use App\Repositories\StaticPageRepository;

class StaticPagesController
{
    public function __construct(
        public StaticPageRepository $staticPageRepository,
    ){}

    public function index(string $slug)
    {
        try {
            $pageContent = StaticPage::where('slug', $slug)->where('active', '1')->first();
            $static_pages = $this->staticPageRepository->getAllStaticPages();
            return WebResponse::success(view('elitvid.site.static_page', compact('pageContent', 'static_pages')));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }
}
