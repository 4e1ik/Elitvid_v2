@extends('layouts.elitvid.elitvid')

@section('body-class', 'rd-page')

@section('content')
    <main>
        @include('includes.elitvid.popup_application')
        <section class="rd-hero rd-hero--crumbs rd-hero--flowerbeds">
            <div class="rd-wrap">
                <x-elitvid.breadcrumbs />
                <h1>Сборные клумбы</h1>
                <p>Клумбы из полистоуна на заказ — индивидуальные размеры и формы | ЭЛИТ ВИД</p>
                <div class="rd-hero__photo" role="img" aria-label="Сборные клумбы из полистоуна"></div>
                <button class="rd-btn rd-btn--accent open_popup_application" type="button">Оставить заявку</button>
            </div>
        </section>

        <div class="rd-wrap">
            @if($pageContent && $pageContent->category_description)
                <section class="rd-section rd-text">{!! $pageContent->category_description !!}</section>
            @endif
            @if(isset($pageContent->gallery) && $pageContent->gallery->active && $pageContent->gallery->images->isNotEmpty())
                <x-elitvid.works title="Примеры работ" :images="$pageContent->gallery->images" />
            @endif
        </div>
    </main>
@endsection
