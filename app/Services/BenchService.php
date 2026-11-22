<?php

namespace App\Services;

use App\Repositories\BenchRepository;

class BenchService
{
    public function __construct(
        public BenchRepository $benches,
    ) {}

    /** Куда ведёт старый адрес товара Street furniture: перенесённый в Lines — к нему, остальные — на «Скамьи из камня». */
    public function streetFurnitureTarget(string $slug): string
    {
        return $this->benches->collectionOf($slug) === 'lines'
            ? route('show_bench_product', ['collection' => 'lines', 'slug' => $slug])
            : route('benches');
    }
}
