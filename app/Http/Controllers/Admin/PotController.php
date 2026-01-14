<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Repositories\Admin\PotRepository;

class PotController
{
    public function __construct(
        public PotRepository $potRepository
    ){}

    public function round_pots() {

        $products = $this->potRepository->getPots('Round');

        return view('elitvid.admin.pots.round_pots', compact( 'products'));
    }

    public function rectangular_pots() {
        $products = $this->potRepository->getPots('Rectangular');

        return view('elitvid.admin.pots.rectangular_pots', compact('products'));
    }

    public function square_pots() {
        $products = $this->potRepository->getPots('Square');

        return view('elitvid.admin.pots.square_pots', compact('products'));
    }
}
