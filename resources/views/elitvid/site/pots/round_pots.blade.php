@extends('layouts.elitvid.elitvid')

@section('content')
    <section class="round-pots__main section-item">
        <div class="container">
            <div class="square-pots__main-header section-header">
                <h2>Круглые кашпо</h2>
            </div>
            <div class="product__main-items">
                @foreach($round_pots as $pot)
                    <div class="product__item-card">
                        <div class="product__item-slider">
                            <div class="swiper-product">
                                <div class="swiper-wrapper">
                                    <!-- Slides -->
                                    @foreach($pot->images as $image)
                                        <div class="swiper-slide">
                                            <img src="{{ asset('storage/'.$image->image) }}" alt="{{ $image->description_image }}">
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
                        <div class="product__card-header">
                            <p>{{$pot->title}}</p>
                        </div>
                        <details>
                            <summary>Размеры</summary>
                            <div class="content-product">
                                {!! $pot->content !!}
                            </div>
                        </details>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
