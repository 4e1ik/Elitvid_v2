<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Repositories\Admin\BenchRepository;

class BenchController
{
    public function __construct(
        public BenchRepository $benchRepository
    ){}

    public function verona() {
        $products = $this->benchRepository->getBenches('Verona');
        return view('elitvid.admin.benches.benches_verona', compact('products'));
    }

    public function stones() {
        $products = $this->benchRepository->getBenches('Stones');
        return view('elitvid.admin.benches.benches_stones', compact('products'));
    }

    public function solo() {
        $products = $this->benchRepository->getBenches('Solo');
        return view('elitvid.admin.benches.benches_solo', compact('products'));
    }

    public function lines() {
        $products = $this->benchRepository->getBenches('lines');
        return view('elitvid.admin.benches.benches_lines', compact('products'));
    }

    public function street_furniture() {
        $products = $this->benchRepository->getBenches('Street_furniture');
        return view('elitvid.admin.benches.benches_street_furniture', compact('products'));
    }
}
