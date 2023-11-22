@extends('layouts.elitvid.elitvid')

@section('content')
    <section class="round-pots__main section-item">
        <div class="container">
            <div class="square-pots__main-header section-header">
                <h2>Круглые кашпо</h2>
            </div>
            @include('includes.elitvid.catalog_price_pots')
            <div class="product__main-items">
                @foreach($round_pots as $pot)
                    <div class="product__item-card">
                        <a href="{{route('show_product', ['id' => $pot->id])}}">
                            <div class="product__item-slider">
                                <div class="swiper-product">
                                    <div class="swiper-wrapper">
                                        <!-- Slides -->
                                        <div class="swiper-slide">
                                            <img src="{{ asset('storage/'.$pot->images[0]->image) }}"
                                                 alt="{{ $pot->images[0]->description_image }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product__card-header">
                                <p>{{$pot->title}}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
