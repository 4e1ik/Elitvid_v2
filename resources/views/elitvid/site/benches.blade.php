@extends('layouts.elitvid.elitvid')

@section('content')
    <section class="pots__main section-item">
        <div class="container">
            <div class="pots__main-header section-header">
                <h2>Скамьи</h2>
            </div>
            @include('includes.elitvid.catalog_price_benches')
            <div class="texture__name-header second_section-header">
                <h3>Коллекция Stones</h3>
            </div>
            <div class="product__main-items">
                @foreach($stones_benches as $bench)
                    <div class="product__item-card">
                        <div class="product__item-slider">
                            <div class="swiper-product">
                                <div class="swiper-wrapper">
                                    <!-- Slides -->
                                    @foreach($bench->images as $image)
                                        <div class="swiper-slide">
{{--                                            <img src="{{ asset('storage/'.$image->image) }}" alt="{{$image->description_image}}">--}}
                                            <a href="{{ asset('storage/'.$image->image) }}" data-lightbox="{{$bench->id}}-images"><img
                                                    src="{{ asset('storage/'.$image->image) }}" alt="{{$image->description_image}}"></a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-prev">
                                    <img src="{{asset('/elitvid_assets/images/slider/prev.png')}}" alt="">
                                </div>
                                <div class="swiper-button-next">
                                    <img src="{{asset('/elitvid_assets/images/slider/next.png')}}" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="product__card-content">
                            <div class="product__card-header">
                                <p>{{$bench->title}}</p>
                            </div>
                            <div class="content-product">
                                {!! $bench->content !!}
                            </div>
                        </div>
{{--                        <div class="product__card-header">--}}
{{--                            <p>{{$bench->title}}</p>--}}
{{--                        </div>--}}
{{--                        <details>--}}
{{--                            <summary>Размеры</summary>--}}
{{--                            <div class="content-product">--}}
{{--                                {!! $bench->content !!}--}}
{{--                            </div>--}}
{{--                        </details>--}}
                    </div>
                @endforeach
            </div>
            <div class="texture__name-header second_section-header">
                <h3>Скамьи бетонные Radius</h3>
            </div>
            <div class="product__main-items">
                @foreach($radius_benches as $bench)
                    <div class="product__item-card">
                        <div class="product__item-slider">
                            <div class="swiper-product">
                                <div class="swiper-wrapper">
                                    <!-- Slides -->
                                    @foreach($bench->images as $image)
                                        <div class="swiper-slide">
{{--                                            <img src="{{ asset('storage/'.$image->image) }}" alt="{{$image->description_image}}">--}}
                                            <a href="{{ asset('storage/'.$image->image) }}" data-lightbox="{{$bench->id}}-images"><img
                                                    src="{{ asset('storage/'.$image->image) }}" alt="{{$image->description_image}}"></a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-prev">
                                    <img src="{{asset('/elitvid_assets/images/slider/prev.png')}}" alt="">
                                </div>
                                <div class="swiper-button-next">
                                    <img src="{{asset('/elitvid_assets/images/slider/next.png')}}" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="product__card-content">
                            <div class="product__card-header">
                                <p>{{$bench->title}}</p>
                            </div>
                            <div class="content-product">
                                {!! $bench->content !!}
                            </div>
                        </div>
{{--                        <div class="product__card-header">--}}
{{--                            <p>{{$bench->title}}</p>--}}
{{--                        </div>--}}
{{--                        <details>--}}
{{--                            <summary>Размеры</summary>--}}
{{--                            <div class="content-product">--}}
{{--                                {!! $bench->content !!}--}}
{{--                            </div>--}}
{{--                        </details>--}}
                    </div>
                @endforeach
            </div>
            <div class="texture__name-header second_section-header">
                <h3>Скамьи бетонные Solo</h3>
            </div>
            <div class="product__main-items">
                @foreach($solo_benches as $bench)
                    <div class="product__item-card">
                        <div class="product__item-slider">
                            <div class="swiper-product">
                                <div class="swiper-wrapper">
                                    <!-- Slides -->
                                    @foreach($bench->images as $image)
                                        <div class="swiper-slide">
{{--                                            <img src="{{ asset('storage/'.$image->image) }}" alt="{{$image->description_image}}">--}}
                                            <a href="{{ asset('storage/'.$image->image) }}" data-lightbox="{{$bench->id}}-images"><img
                                                    src="{{ asset('storage/'.$image->image) }}" alt="{{$image->description_image}}"></a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-prev">
                                    <img src="{{asset('/elitvid_assets/images/slider/prev.png')}}" alt="">
                                </div>
                                <div class="swiper-button-next">
                                    <img src="{{asset('/elitvid_assets/images/slider/next.png')}}" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="product__card-content">
                            <div class="product__card-header">
                                <p>{{$bench->title}}</p>
                            </div>
                            <div class="content-product">
                                {!! $bench->content !!}
                            </div>
                        </div>
{{--                        <div class="product__card-header">--}}
{{--                            <p>{{$bench->title}}</p>--}}
{{--                        </div>--}}
{{--                        <details>--}}
{{--                            <summary>Размеры</summary>--}}
{{--                            <div class="content-product">--}}
{{--                                {!! $bench->content !!}--}}
{{--                            </div>--}}
{{--                        </details>--}}
                    </div>
                @endforeach
            </div>
            <div class="texture__name-header second_section-header">
                <h3>Скамьи бетонные, уличная мебель</h3>
            </div>
            <div class="product__main-items">
                @foreach($outdoor_benches as $bench)
                    <div class="product__item-card">
                        <div class="product__item-slider">
                            <div class="swiper-product">
                                <div class="swiper-wrapper">
                                    <!-- Slides -->
                                    @foreach($bench->images as $image)
                                        <div class="swiper-slide">
{{--                                            <img src="{{ asset('storage/'.$image->image) }}" alt="{{$image->description_image}}">--}}
                                            <a href="{{ asset('storage/'.$image->image) }}" data-lightbox="{{$bench->id}}-images"><img
                                                    src="{{ asset('storage/'.$image->image) }}" alt="{{$image->description_image}}"></a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-prev">
                                    <img src="{{asset('/elitvid_assets/images/slider/prev.png')}}" alt="">
                                </div>
                                <div class="swiper-button-next">
                                    <img src="{{asset('/elitvid_assets/images/slider/next.png')}}" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="product__card-content">
                            <div class="product__card-header">
                                <p>{{$bench->title}}</p>
                            </div>
                            <div class="content-product">
                                {!! $bench->content !!}
                            </div>
                        </div>
{{--                        <div class="product__card-header">--}}
{{--                            <p>{{$bench->title}}</p>--}}
{{--                        </div>--}}
{{--                        <details>--}}
{{--                            <summary>Размеры</summary>--}}
{{--                            <div class="content-product">--}}
{{--                                {!! $bench->content !!}--}}
{{--                            </div>--}}
{{--                        </details>--}}
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="texture__main section-item">
        <div class="container">
            <div class="texture__main-header section-header">
                <h2>Порода для изготовления деревянных элементов скамьи</h2>
            </div>
            <div class="texture__main-items">
                @foreach($wood_species as $specie)
                    <div class="texture__item-card">
                        @foreach($specie->images as $image)
                            <img src="{{ asset('storage/'.$image->image) }}" alt="{{$image->description_image}}">
                        @endforeach
                        <div class="texture__card-header">
                            <h3><a href="">{{$specie->texture_name}}</a></h3>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="texture__name-header second_section-header">
                <h3>Пропитка</h3>
            </div>
            <div class="texture__main-items">
                @foreach($wood_impregnation as $impregnation)
                    <div class="texture__item-card">
                        @foreach($impregnation->images as $image)
                            <img src="{{ asset('storage/'.$image->image) }}" alt="{{$image->description_image}}">
                        @endforeach
                        <div class="texture__card-header">
                            <h3><a href="">{{$impregnation->texture_name}}</a></h3>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="gallery__main section-item">
        <div class="container">
            <div class="gallery__main-header section-header">
                <h2>Примеры работ</h2>
            </div>
            <div class="gallery__main-items">
                @foreach($benches_gallery as $benches_images)
                    @foreach($benches_images->images as $image)
                    <div class="gallery__item-card">
                        <a href="{{ asset('storage/'.$image->image) }}" data-lightbox="benches-images"><img
                                src="{{ asset('storage/'.$image->image) }}" alt="{{$image->description_image}}"></a>
                    </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </section>
@endsection
