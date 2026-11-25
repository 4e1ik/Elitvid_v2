<?php

namespace Tests\Feature;

use App\Models\PageContent;
use App\Services\Admin\PageContentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PageContentGalleryCaptionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_captions_from_upload_form_are_saved_per_image(): void
    {
        Storage::fake('public');
        $page = PageContent::where('page', 'flowerbeds')->firstOrFail();

        app(PageContentService::class)->update([
            'gallery_images' => [UploadedFile::fake()->image('a.jpg'), UploadedFile::fake()->image('b.jpg')],
            'gallery_descriptions' => ['Подпись А', null],
        ], $page);

        $this->assertSame(
            ['Подпись А', null],
            $page->refresh()->gallery->images()->reorder('id')->pluck('description_image')->all()
        );
    }

    public function test_upload_without_captions_field_does_not_fail(): void
    {
        Storage::fake('public');
        $page = PageContent::where('page', 'flowerbeds')->firstOrFail();

        app(PageContentService::class)->update([
            'gallery_images' => [UploadedFile::fake()->image('a.jpg')],
        ], $page);

        $this->assertSame([null], $page->refresh()->gallery->images()->pluck('description_image')->all());
    }
}
