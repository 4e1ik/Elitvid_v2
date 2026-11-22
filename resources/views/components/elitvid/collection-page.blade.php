{{-- Страница коллекции (кашпо или скамьи): первый экран, «Выберите форму», SEO-текст --}}
@props(['title', 'text', 'hero', 'catalog', 'products', 'productRoute', 'collection', 'pageContent' => null])

<main>
    @include('includes.elitvid.popup_application')
    <section class="rd-hero rd-hero--crumbs rd-hero--{{ $hero }}">
        <div class="rd-wrap">
            <x-elitvid.breadcrumbs />
            <h1>{{ $title }}</h1>
            <p>{{ $text }}</p>
            <div class="rd-hero__photo" role="img" aria-label="{{ $title }}"></div>
            <div class="rd-hero__actions">
                <button class="rd-btn rd-btn--accent open_popup_application" type="button">Оставить заявку</button>
                <x-elitvid.download-catalog :file="$catalog" />
            </div>
        </div>
    </section>

    <div class="rd-wrap">
        <section class="rd-section">
            <h2>Выберите форму</h2>
            <div class="rd-grid">
                @foreach ($products as $product)
                    <x-elitvid.direction-card
                        class="rd-card--product"
                        :href="route($productRoute, ['collection' => $collection, 'slug' => $product->slug])"
                        :image="$product->images->first() ? asset('storage/' . str_replace('public/', '', $product->images->first()->image)) : ''"
                        :alt="$product->images->first()?->description_image ?? ''"
                        :label="$product->name" />
                @endforeach
            </div>
        </section>
        @if ($pageContent && $pageContent->category_description)
            <section class="rd-section rd-seo">{!! $pageContent->category_description !!}</section>
        @endif
    </div>
</main>
