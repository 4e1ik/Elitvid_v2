<?php

namespace Tests\Feature;

use App\Models\Pot;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// Спека 012: квадратные и прямоугольные кашпо — одно направление.
class SquareRectangularPotsTest extends TestCase
{
    use RefreshDatabase;

    private function pot(string $name, string $slug): void
    {
        $product = Product::create(['name' => $name, 'slug' => $slug, 'product_type' => 'pot', 'active' => true]);
        Pot::create(['product_id' => $product->id, 'collection' => 'Square_rectangular', 'material' => 'бетон', 'data' => []]);
        $product->images()->create(['image' => "public/images/$slug.webp"]);
    }

    private function newProductUrl(string $slug): string
    {
        return route('show_pot_product', ['collection' => 'kvadratnye-i-pryamougolnye', 'slug' => $slug]);
    }

    public function test_merged_page_lists_products_of_both_former_collections(): void
    {
        $this->pot('CUBE', 'cube');
        $this->pot('BOX', 'box');

        $this->get('/napravleniya/kashpo/kvadratnye-i-pryamougolnye')
            ->assertOk()
            ->assertSee('Квадратные и прямоугольные', false)
            ->assertSee('CUBE')
            ->assertSee('BOX')
            ->assertSee($this->newProductUrl('cube'), false);
    }

    public function test_pots_catalog_has_one_tile_for_merged_direction(): void
    {
        $html = $this->get(route('pots'))->assertOk()->getContent();

        $this->assertStringContainsString(route('square_rectangular_pots'), $html);
        $this->assertStringContainsString('square_pot.webp', $html);
        $this->assertStringNotContainsString('rectangular_pot.webp', $html);
        $this->assertStringNotContainsString('/kashpo/kvadratnye"', $html);
        $this->assertStringNotContainsString('/kashpo/pryamougolnye"', $html);
    }

    public function test_product_page_links_back_to_merged_direction(): void
    {
        $this->pot('CUBE', 'cube');

        $this->get($this->newProductUrl('cube'))
            ->assertOk()
            ->assertSee(route('square_rectangular_pots'), false)
            ->assertSee('Квадратные и прямоугольные кашпо');
    }

    public function test_old_direction_pages_redirect_permanently(): void
    {
        foreach (['kvadratnye', 'pryamougolnye'] as $segment) {
            $this->get("/napravleniya/kashpo/$segment")
                ->assertStatus(301)
                ->assertRedirect(route('square_rectangular_pots'));
        }
    }

    public function test_old_product_addresses_redirect_permanently(): void
    {
        $this->get('/napravleniya/kashpo/kvadratnye/cube')->assertStatus(301)->assertRedirect($this->newProductUrl('cube'));
        $this->get('/napravleniya/kashpo/pryamougolnye/box')->assertStatus(301)->assertRedirect($this->newProductUrl('box'));
    }

    public function test_sitemap_lists_only_merged_addresses(): void
    {
        $this->pot('CUBE', 'cube');

        $xml = $this->get('/sitemap.xml')->assertOk()->getContent();

        $this->assertStringContainsString(route('square_rectangular_pots') . '<', $xml);
        $this->assertStringContainsString($this->newProductUrl('cube'), $xml);
        $this->assertStringNotContainsString('/kashpo/kvadratnye<', $xml);
        $this->assertStringNotContainsString('/kashpo/kvadratnye/', $xml);
        $this->assertStringNotContainsString('/kashpo/pryamougolnye', $xml);
    }
}
