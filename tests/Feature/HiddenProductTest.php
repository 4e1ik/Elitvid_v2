<?php

namespace Tests\Feature;

use App\Models\Bench;
use App\Models\Pot;
use App\Models\Product;
use App\Models\Urn;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HiddenProductTest extends TestCase
{
    use RefreshDatabase;

    /** @return array<string, string> тип => адрес карточки */
    private function products(bool $active): array
    {
        $suffix = $active ? 'on' : 'off';

        $bench = Product::create(['name' => "B $suffix", 'slug' => "bench-$suffix", 'product_type' => 'bench', 'active' => $active]);
        Bench::create(['product_id' => $bench->id, 'collection' => 'lines', 'material' => 'бетон', 'data' => []]);

        $pot = Product::create(['name' => "P $suffix", 'slug' => "pot-$suffix", 'product_type' => 'pot', 'active' => $active]);
        Pot::create(['product_id' => $pot->id, 'collection' => 'Round', 'material' => 'бетон', 'data' => []]);

        $urn = Product::create(['name' => "U $suffix", 'slug' => "urn-$suffix", 'product_type' => 'urn', 'active' => $active]);
        Urn::create(['product_id' => $urn->id, 'material' => 'бетон', 'data' => []]);

        // карточка товара без фото не рендерится
        foreach ([$bench, $pot, $urn] as $product) {
            $product->images()->create(['image' => "public/images/{$product->slug}.webp"]);
        }

        return [
            'bench' => route('show_bench_product', ['collection' => 'lines', 'slug' => "bench-$suffix"]),
            'pot' => route('show_pot_product', ['collection' => 'kruglye', 'slug' => "pot-$suffix"]),
            'urn' => route('show_urn_product', ['slug' => "urn-$suffix"]),
        ];
    }

    public function test_hidden_product_is_not_found_and_active_opens(): void
    {
        foreach ($this->products(false) as $url) {
            $this->get($url)->assertNotFound();
        }
        foreach ($this->products(true) as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_hidden_product_is_not_found_for_admin_too(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        foreach ($this->products(false) as $url) {
            $this->actingAs($admin)->get($url)->assertNotFound();
        }
    }
}
