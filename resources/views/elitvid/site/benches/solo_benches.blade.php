
@extends('layouts.elitvid.elitvid')

@section('content')
    <main>
        @include('includes.elitvid.popup_call')
        @include('includes.elitvid.popup_application')
        @include('includes.elitvid.breadcrumbs')
        <section class="main">
            <div class="description">
                <div class="description-text">
                    <h1>Коллекция <br>solo</h1>
                    <p>Подойдёт для торговых центров, стильно впишется в любой дизайн-проект. Модели можно комбинировать между собой.</p>
                </div>
                <div class="submit-application">
                    <button class="submit-application--button open_popup_application">
                        Оставить заявку
                    </button>
                </div>
                @include('includes.elitvid.catalog_price_benches')
            </div>
            <div class="stages">
                <div class="image">
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/benches/collections/solo/solo.png')}}" alt="Фотография три кашпо в ряд"
                         class="main-page-up">
                </div>
                <div class="submit-application submit-application--mobile">
                    <button class="submit-application--button open_popup_application1 submit-application-button--mobile">
                        Оставить заявку
                    </button>
                </div>
                @include('includes.elitvid.mobile_catalog_price_benches')
            </div>
        </section>
        <section class="not_main_page produce">
            <h2>Выберите форму</h2>
            <div class="not_main_page directions">
                @foreach($solo_benches as $product)
                    <div class="direction">
                        <img src="{{asset('storage/'.str_replace('public/','',$product->bench_images[0]->image))}}" alt="Фотография направления">
                        <a href="{{route('show_bench_product', ['id' => $product->id])}}">
                            <button>{{$product->name}}</button>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
        @if($category)
            <section class="description">
                <div class="text">
                    {!! $category !!}
                </div>
            </section>
        @endif
    </main>
@endsection
