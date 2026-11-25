<?php

namespace Tests\Feature;

use App\Models\Pot;
use App\Models\Product;
use App\Models\Urn;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrnPagesTest extends TestCase
{
    use RefreshDatabase;

    private function urn(string $name, bool $active = true): Product
    {
        $product = Product::create(['name' => $name, 'slug' => strtolower($name), 'product_type' => 'urn', 'active' => $active]);
        Urn::create(['product_id' => $product->id, 'material' => 'полимербетон', 'data' => [['size' => '500*500*500', 'weight' => '', 'price' => '']]]);
        $product->images()->create(['image' => 'public/images/' . strtolower($name) . '.webp']);

        return $product;
    }

    public function test_list_shows_only_active_urns(): void
    {
        $this->urn('TITAN');
        $this->urn('HIDDEN', false);

        $this->get(route('urns'))
            ->assertOk()
            ->assertSee('Урны из полистоуна')
            ->assertSee(route('show_urn_product', ['slug' => 'titan']))
            ->assertDontSee('HIDDEN');
    }

    public function test_card_shows_urn(): void
    {
        $this->urn('TITAN');

        $this->get(route('show_urn_product', ['slug' => 'titan']))
            ->assertOk()
            ->assertSee('полимербетон')
            ->assertSee('500*500*500');
    }

    public function test_ot_shown_only_with_price(): void
    {
        $urn = $this->urn('TITAN');
        $urn->urn->update(['data' => [
            ['size' => '500', 'weight' => '', 'price' => '100'],
            ['size' => '600', 'weight' => '', 'price' => ''],
        ]]);

        $html = $this->get(route('show_urn_product', ['slug' => 'titan']))->getContent();
        $this->assertSame(4, substr_count($html, '<p>Цена</p>') + substr_count($html, 'от 100'));
        $this->assertSame(2, substr_count($html, 'от 100'));
        $this->assertDoesNotMatchRegularExpression('/>\s*от\s*</u', $html);
    }

    public function test_pot_slug_is_not_an_urn(): void
    {
        $pot = Product::create(['name' => 'CUBE', 'slug' => 'cube', 'product_type' => 'pot', 'active' => true]);
        Pot::create(['product_id' => $pot->id, 'collection' => 'Square', 'material' => 'Полимербетон', 'data' => []]);

        $this->get(route('show_urn_product', ['slug' => 'cube']))->assertNotFound();
    }

    public function test_urn_can_be_added_to_cart(): void
    {
        $urn = $this->urn('TITAN');

        $this->post(route('cart.add'), ['product_id' => $urn->id])->assertSessionHasNoErrors();
        $this->get(route('cart.show'))->assertSee('TITAN');
    }
}
