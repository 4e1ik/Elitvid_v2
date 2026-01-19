
@extends('layouts.elitvid.elitvid')

@section('content')
    <main>
        @include('includes.elitvid.popup_call')
        @include('includes.elitvid.popup_application')
        @include('includes.elitvid.breadcrumbs')
        <section class="main">
            <div class="description">
                <div class="description-text">
                    <h1>Коллекция <br>stones</h1>
                    <p>Идеальна для создания стильных пространств возле офисов и в парковых зонах.</p>
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
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/benches/collections/stones/stones.webp')}}"
                         alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/benches/collections/stones/stones.webp']}}"
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
                @foreach($products as $product)
                    <div class="direction">
                        <img src="{{asset('storage/'.str_replace('public/','',$product->images->first()->image))}}" alt="{{$product->images->first()->description_image}}">
                        <a href="{{route('show_bench_product', ['collection' => 'stones_benches', 'id' => $product->id])}}">
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
