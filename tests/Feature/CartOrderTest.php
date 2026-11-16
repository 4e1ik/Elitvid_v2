<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CartOrderTest extends TestCase
{
    public function test_order_is_saved_and_written_to_the_log(): void
    {
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true]),
        ]);

        $this->withSession(['cart' => [1 => 2, 2 => 1]])
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
            'product_id' => 1,
            'product_name' => 'CUBE',
            'quantity' => 2,
        ]);
        $this->assertDatabaseHas('order_items', [
            'product_id' => 2,
            'product_name' => 'KOLONNA',
            'quantity' => 1,
        ]);

        $admin = User::query()->where('role', 'admin')->first();
        $this->actingAs($admin)
            ->get(route('admin_orders.index'))
            ->assertOk()
            ->assertSee('CUBE')
            ->assertSee('KOLONNA');

        $this->actingAs($admin)
            ->get(route('admin_orders.index', ['date_from' => '2099-01-01']))
            ->assertOk()
            ->assertDontSee('test@example.com');

        $csv = $this->actingAs($admin)->get(route('admin_orders.export', [
            'date_from' => '2026-11-16',
            'date_to' => '2026-11-16',
        ]));
        $csv->assertOk();
        $this->assertStringContainsString('CUBE × 2; KOLONNA × 1', $csv->getContent());
        $this->assertStringContainsString('Дата;Имя;Почта;Телефон;Организация;Комментарий;Товары', $csv->getContent());
    }
}
