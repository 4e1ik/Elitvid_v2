<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CartOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_is_saved_and_written_to_the_log(): void
    {
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true]),
        ]);

        $cube = Product::create(['name' => 'CUBE', 'slug' => 'cube', 'product_type' => 'pot', 'active' => true]);
        $kolonna = Product::create(['name' => 'KOLONNA', 'slug' => 'kolonna', 'product_type' => 'bench', 'active' => true]);
        $admin = User::factory()->create(['role' => 'admin']);

        $this->withSession(['cart' => [$cube->id => 2, $kolonna->id => 1]])
            ->post('/cart/order', [
                'name' => 'Тест',
                'email' => 'test@example.com',
                'phone' => '291112233',
                'country' => '🇧🇾 +375',
                'name_corp' => 'Проверка',
                'textarea' => 'Два товара',
                'g-recaptcha-response' => 'token',
            ])
            ->assertRedirect(route('cart.show'));

        $this->assertDatabaseHas('orders', [
            'name' => 'Тест',
            'email' => 'test@example.com',
            'corporation_name' => 'Проверка',
            'comment' => 'Два товара',
        ]);
        $this->assertDatabaseHas('order_items', [
            'product_id' => $cube->id,
            'product_name' => 'CUBE',
            'quantity' => 2,
        ]);
        $this->assertDatabaseHas('order_items', [
            'product_id' => $kolonna->id,
            'product_name' => 'KOLONNA',
            'quantity' => 1,
        ]);

        // The filters compare calendar dates, so take the day from the order itself.
        $day = Order::firstOrFail()->created_at->toDateString();

        $this->actingAs($admin)
            ->get(route('admin_orders.index'))
            ->assertOk()
            ->assertSee('CUBE')
            ->assertSee('KOLONNA');

        $this->actingAs($admin)
            ->get(route('admin_orders.index', ['date_from' => Carbon::parse($day)->addDay()->toDateString()]))
            ->assertOk()
            ->assertDontSee('test@example.com');

        $csv = $this->actingAs($admin)->get(route('admin_orders.export', [
            'date_from' => $day,
            'date_to' => $day,
        ]));
        $csv->assertOk();
        $this->assertStringContainsString('CUBE × 2; KOLONNA × 1', $csv->getContent());
        $this->assertStringContainsString('Дата;Имя;Почта;Телефон;Организация;Комментарий;Товары', $csv->getContent());
    }
}
