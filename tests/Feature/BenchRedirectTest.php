<?php

namespace Tests\Feature;

use App\Models\Bench;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BenchRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_street_furniture_list_redirects_to_benches(): void
    {
        $this->get('/napravleniya/skami/street-furniture')
            ->assertStatus(301)
            ->assertRedirect(route('benches'));
    }

    public function test_bench_moved_to_lines_redirects_to_its_lines_address(): void
    {
        $product = Product::create(['name' => 'SK. YS 003', 'slug' => 'sk-ys-003', 'product_type' => 'bench', 'active' => true]);
        Bench::create(['product_id' => $product->id, 'collection' => 'lines', 'material' => 'Полимербетон', 'data' => []]);

        $this->get('/napravleniya/skami/street-furniture/sk-ys-003')
            ->assertStatus(301)
            ->assertRedirect(route('show_bench_product', ['collection' => 'lines', 'slug' => 'sk-ys-003']));
    }

    public function test_other_street_furniture_bench_redirects_to_benches(): void
    {
        $product = Product::create(['name' => 'SK. YS 001', 'slug' => 'sk-ys-001', 'product_type' => 'bench', 'active' => false]);
        Bench::create(['product_id' => $product->id, 'collection' => 'Street_furniture', 'material' => 'Полимербетон', 'data' => []]);

        $this->get('/napravleniya/skami/street-furniture/sk-ys-001')
            ->assertStatus(301)
            ->assertRedirect(route('benches'));
    }
}
