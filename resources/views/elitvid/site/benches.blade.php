@extends('layouts.elitvid.elitvid')

@section('body-class', 'rd-page')

@section('content')
    @php
        $collectionImage = fn (string $name) => asset("/elitvid_assets/newDesign/newDesign/imgs/benches/collections/{$name}/main_{$name}.webp");
        $collectionAlt = fn (string $name) => $static_images_arr["/elitvid_assets/newDesign/newDesign/imgs/benches/collections/{$name}/main_{$name}.webp"] ?? '';
    @endphp
    <main>
        @include('includes.elitvid.popup_application')
        <section class="rd-hero rd-hero--crumbs rd-hero--benches">
            <div class="rd-wrap">
                <x-elitvid.breadcrumbs />
                <h1>Скамьи из камня</h1>
                <p>Доверьте нам свои идеи, и мы поможем Вам воплотить их в жизнь. Свяжитесь с нами сегодня и начните реализацию своего проекта!</p>
                <div class="rd-hero__photo" role="img" aria-label="Скамьи из камня"></div>
                <div class="rd-hero__actions">
                    <button class="rd-btn rd-btn--accent open_popup_application" type="button">Оставить заявку</button>
                    <x-elitvid.download-catalog file="/elitvid_assets/newDesign/newDesign/files/benches.pdf" />
                </div>
            </div>
        </section>

        <div class="rd-wrap">
            <section class="rd-section">
                <h2>Коллекции каменных скамеек</h2>
                <div class="rd-forms rd-forms--side">
                    <x-elitvid.form-row side :image="$collectionImage('verona')" :alt="$collectionAlt('verona')" title="Verona" :href="route('verona_benches')">
                        Коллекция с потрясающими природными формами, гармонично впишется в любой ландшафт.
                    </x-elitvid.form-row>
                    <x-elitvid.form-row side :image="$collectionImage('stones')" :alt="$collectionAlt('stones')" title="Stones" :href="route('stones_benches')">
                        Идеальна для создания стильных пространств возле офисов и в парковых зонах.
                    </x-elitvid.form-row>
                    <x-elitvid.form-row side :image="$collectionImage('lines')" :alt="$collectionAlt('lines')" title="Lines" :href="route('lines_benches')">
                        Подходят для создания различных композиций в торговых центрах и на улице.
                    </x-elitvid.form-row>
                    <x-elitvid.form-row side :image="$collectionImage('solo')" :alt="$collectionAlt('solo')" title="Solo" :href="route('solo_benches')">
                        Подойдёт для торговых центров, стильно впишется в любой дизайн-проект.
                    </x-elitvid.form-row>
                </div>
            </section>
            @if($pageContent && $pageContent->category_description)
                <section class="rd-section rd-seo">{!! $pageContent->category_description !!}</section>
            @endif
            @if(isset($pageContent->gallery) && $pageContent->gallery->active)
                <x-elitvid.works title="Примеры работ" :images="$pageContent->gallery->images" />
            @endif
        </div>
    </main>
@endsection
