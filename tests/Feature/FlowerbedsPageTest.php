<?php

namespace Tests\Feature;

use App\Models\PageContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FlowerbedsPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_page_shows_admin_text_and_is_linked_from_catalog(): void
    {
        // запись создаёт миграция 2026_11_21_120000_add_flowerbeds_page_content
        PageContent::where('page', 'flowerbeds')->firstOrFail()
            ->update(['category_description' => '<p>Текст из админки</p>']);

        $this->get('/napravleniya/sbornye-klumby')
            ->assertOk()
            ->assertSee('Сборные клумбы')
            ->assertSee('Текст из админки', false);

        $this->get(route('directions'))
            ->assertOk()
            ->assertSee(route('flowerbeds'), false);
    }
}
