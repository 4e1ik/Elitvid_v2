@extends('layouts.elitvid.elitvid')

@section('body-class', 'rd-page')

@section('content')
    <main>
        @include('includes.elitvid.popup_application')
        <section class="rd-hero rd-hero--crumbs rd-hero--urns">
            <div class="rd-wrap">
                <x-elitvid.breadcrumbs />
                <h1>Урны из полистоуна</h1>
                <p>Уличные урны из полистоуна — стильное и практичное решение для благоустройства современных пространств. Урны устойчивы к атмосферным воздействиям и оснащаются съёмными металлическими вкладышами. Разнообразие форм, размеров и цветовых решений позволяет гармонично вписать их в любую архитектурную среду. <b>ЭЛИТ ВИД</b> предлагает как готовые модели, так и изготовление урн по индивидуальным проектам.</p>
                <div class="rd-hero__photo" role="img" aria-label="Урны из полистоуна"></div>
                <button class="rd-btn rd-btn--accent open_popup_application" type="button">Оставить заявку</button>
            </div>
        </section>

        <div class="rd-wrap">
            <section class="rd-section">
                <div class="rd-grid">
                    @foreach ($products as $product)
                        <x-elitvid.direction-card
                            class="rd-card--product"
                            :href="route('show_urn_product', ['slug' => $product->slug])"
                            :image="$product->images->first() ? asset('storage/' . str_replace('public/', '', $product->images->first()->image)) : ''"
                            :alt="$product->images->first()?->description_image ?? ''"
                            :label="$product->name" />
                    @endforeach
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
