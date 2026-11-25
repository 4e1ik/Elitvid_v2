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

    public function square_rectangular_pots() {
        try {
            $products = $this->potRepository->getPots('Square_rectangular');
            return WebResponse::success(view('elitvid.admin.pots.pots_square_rectangular', compact('products')));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }
}
