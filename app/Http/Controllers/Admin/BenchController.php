<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\WebResponse;
use App\Models\Product;
use App\Repositories\Admin\BenchRepository;

class BenchController
{
    public function __construct(
        public BenchRepository $benchRepository
    ){}

    public function verona() {
        try {
            $products = $this->benchRepository->getBenches('Verona');
            return WebResponse::success(view('elitvid.admin.benches.benches_verona', compact('products')));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function stones() {
        try {
            $products = $this->benchRepository->getBenches('Stones');
            return WebResponse::success(view('elitvid.admin.benches.benches_stones', compact('products')));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function solo() {
        try {
            $products = $this->benchRepository->getBenches('Solo');
            return WebResponse::success(view('elitvid.admin.benches.benches_solo', compact('products')));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function lines() {
        try {
            $products = $this->benchRepository->getBenches('lines');
            return WebResponse::success(view('elitvid.admin.benches.benches_lines', compact('products')));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function street_furniture() {
        try {
            $products = $this->benchRepository->getBenches('Street_furniture');
            return WebResponse::success(view('elitvid.admin.benches.benches_street_furniture', compact('products')));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }
}
