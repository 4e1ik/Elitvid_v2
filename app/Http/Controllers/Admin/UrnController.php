<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\WebResponse;
use App\Repositories\Admin\UrnRepository;

class UrnController
{
    public function __construct(
        public UrnRepository $urnRepository
    ){}

    public function index()
    {
        try {
            $products = $this->urnRepository->all();
            return WebResponse::success(view('elitvid.admin.urns.urns', compact('products')));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }
}
