<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Urn;
use App\Services\ImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductMainImageTest extends TestCase
{
    use RefreshDatabase;

    private function urn(array $images): Product
    {
        $product = Product::create(['name' => 'TITAN', 'slug' => 'titan', 'product_type' => 'urn', 'active' => true]);
        Urn::create(['product_id' => $product->id, 'material' => 'полимербетон', 'data' => [['size' => '500', 'weight' => '', 'price' => '']]]);
        foreach ($images as $name) {
            $product->images()->create(['image' => "public/images/$name.webp"]);
        }

        return $product->load('images');
    }

    public function test_main_image_defaults_to_first_uploaded(): void
    {
        $this->assertNull($this->urn([])->mainImage());

        Product::query()->delete();
        $this->assertSame('public/images/a.webp', $this->urn(['a', 'b'])->mainImage()->image);
    }

    public function test_marking_main_unmarks_others_and_unmarking_falls_back(): void
    {
        $product = $this->urn(['a', 'b', 'c']);
        [$a, $b, $c] = $product->images->sortBy('id')->values()->all();
        $service = app(ImageService::class);

        $service->update($b, ['main_image' => '1']);
        $service->update($c, ['main_image' => '1']);
        $this->assertSame($c->id, $product->fresh('images')->mainImage()->id);
        $this->assertSame(1, $product->images()->where('main_image', true)->count());

        $service->update($c, ['main_image' => '0']);
        $this->assertSame($a->id, $product->fresh('images')->mainImage()->id);
    }

    public function test_catalog_card_and_product_page_show_main_image(): void
    {
        $product = $this->urn(['first', 'chosen']);
        app(ImageService::class)->update($product->images->firstWhere('image', 'public/images/chosen.webp'), ['main_image' => '1']);

        $this->get(route('urns'))->assertOk()->assertSee('images/chosen.webp')->assertDontSee('images/first.webp');
        $this->get(route('show_urn_product', ['slug' => 'titan']))
            ->assertOk()
            ->assertSeeInOrder(['id="first_image"', 'images/chosen.webp']);
    }
}
