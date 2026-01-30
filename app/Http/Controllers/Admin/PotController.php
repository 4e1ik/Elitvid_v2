<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\WebResponse;
use App\Models\Product;
use App\Repositories\Admin\PotRepository;

class PotController
{
    public function __construct(
        public PotRepository $potRepository
    ){}

    public function round_pots() {
        try {
            $products = $this->potRepository->getPots('Round');
            return WebResponse::success(view('elitvid.admin.pots.pots_round', compact('products')));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function rectangular_pots() {
        try {
            $products = $this->potRepository->getPots('Rectangular');
            return WebResponse::success(view('elitvid.admin.pots.pots_rectangular', compact('products')));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function square_pots() {
        try {
            $products = $this->potRepository->getPots('Square');
            return WebResponse::success(view('elitvid.admin.pots.pots_square', compact('products')));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }
}
