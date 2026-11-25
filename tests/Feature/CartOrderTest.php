<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMail;
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
            'quantity' => 1,
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
        $this->assertStringContainsString('CUBE; KOLONNA', $csv->getContent());
        $this->assertStringContainsString('Дата;Имя;Почта;Телефон;Организация;Комментарий;Товары', $csv->getContent());
    }
    public function test_removing_from_product_page_returns_to_it_and_empties_the_line(): void
    {
        $cube = Product::create(['name' => 'CUBE', 'slug' => 'cube', 'product_type' => 'pot', 'active' => true]);
        $productPage = 'http://localhost/napravleniya/kashpo/kvadratnye/cube';

        $this->withSession(['cart' => [$cube->id => 3]])
            ->from($productPage)
            ->post(route('cart.update', ['product' => $cube->id]), ['quantity' => 0])
            ->assertRedirect($productPage)
            ->assertSessionHas('cart', []);

        $this->assertFalse(app(\App\Services\CartService::class)->has($cube->id));
    }

    public function test_removing_on_cart_page_stays_on_cart_page(): void
    {
        $cube = Product::create(['name' => 'CUBE', 'slug' => 'cube', 'product_type' => 'pot', 'active' => true]);

        $this->withSession(['cart' => [$cube->id => 1]])
            ->from(route('cart.show'))
            ->post(route('cart.update', ['product' => $cube->id]), ['quantity' => 0])
            ->assertRedirect(route('cart.show'))
            ->assertSessionHas('cart', []);
    }

    public function test_adding_twice_keeps_one_line_without_quantity(): void
    {
        $cube = Product::create(['name' => 'CUBE', 'slug' => 'cube', 'product_type' => 'pot', 'active' => true]);

        $this->post(route('cart.add'), ['product_id' => $cube->id]);
        $this->post(route('cart.add'), ['product_id' => $cube->id])
            ->assertSessionHas('cart', [$cube->id => 1]);

        $this->assertTrue(app(\App\Services\CartService::class)->has($cube->id));
    }

    private function placeOrder(): \Illuminate\Testing\TestResponse
    {
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true]),
        ]);
        $cube = Product::create(['name' => 'CUBE', 'slug' => 'cube', 'product_type' => 'pot', 'active' => true]);
        $kolonna = Product::create(['name' => 'KOLONNA', 'slug' => 'kolonna', 'product_type' => 'bench', 'active' => true]);

        return $this->withSession(['cart' => [$cube->id => 1, $kolonna->id => 1]])
            ->post('/cart/order', [
                'name' => 'Тест',
                'email' => 'test@example.com',
                'phone' => '291112233',
                'country' => '🇧🇾 +375',
                'g-recaptcha-response' => 'token',
            ]);
    }

    public function test_order_mail_goes_to_the_feedback_address_with_all_products(): void
    {
        Mail::fake();

        $this->placeOrder()->assertRedirect(route('cart.show'))->assertSessionHas('success', 'Заявка принята.');

        Mail::assertSent(OrderMail::class, 1);
        Mail::assertSent(OrderMail::class, function (OrderMail $mail) {
            $html = $mail->render();

            return $mail->hasTo('el_vid@mail.ru')
                && str_contains($html, 'CUBE')
                && str_contains($html, 'KOLONNA')
                && str_contains($html, '—');
        });
        $this->assertFalse(Order::firstOrFail()->mail_failed);
    }

    public function test_order_is_kept_and_marked_when_mail_fails(): void
    {
        Mail::shouldReceive('to')->andThrow(new \RuntimeException('smtp down'));
        $admin = User::factory()->create(['role' => 'admin']);

        $this->placeOrder()
            ->assertRedirect(route('cart.show'))
            ->assertSessionHas('success', 'Заявка принята.')
            ->assertSessionHas('cart', []);

        $order = Order::firstOrFail();
        $this->assertTrue($order->mail_failed);
        $this->assertCount(2, $order->items);

        $this->actingAs($admin)
            ->get(route('admin_orders.index'))
            ->assertOk()
            ->assertSee('Письмо не отправлено');
    }
}
