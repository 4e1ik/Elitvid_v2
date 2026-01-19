@extends('layouts.elitvid.elitvid')

@section('content')
    <section class="product-card__main section-item">
        <div class="container">
            @foreach($product as $item)
                <div class="product-card__main-header section-header">
                    <h2>{{$item->title}}</h2>
                </div>
                <div class="product-card__content">
                    <div class="product-card__images">
                        @if($item->item == 'pot')
                            @foreach($item->images as $image)
                                <img class="target target-{{$i}}"
                                     src="{{ asset('storage/'.$image->image) }}"
                                     alt="{{ $image->description_image }}" loading="lazy">
                            <div hidden>{{$i++}}</div>
                            @endforeach
                        @else
                            <div class="product__item-slider">
                                <div class="swiper-product">
                                    <div class="swiper-wrapper">
                                        <!-- Slides -->
                                        @foreach($item->images as $image)
                                            <div class="swiper-slide">
                                                <a href="{{ asset('storage/'.$image->image) }}"
                                                   data-lightbox="{{$item->id}}-images"><img
                                                        src="{{ asset('storage/'.$image->image) }}"
                                                        alt="{{$image->description_image}}" loading="lazy"></a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-button-prev">
                                        <img src="{{asset('/elitvid_assets/images/slider/prev.webp')}}" alt="" loading="lazy">
                                    </div>
                                    <div class="swiper-button-next">
                                        <img src="{{asset('/elitvid_assets/images/slider/next.webp')}}" alt="" loading="lazy">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="product-card__description">
                        <div class="product-description__text">
                            {!! $item->content !!}
                        </div>
                        @if($item->item == 'pot')
                            <div class="product-description__colors">
                                @foreach($item->images as $image)
                                    <div class="description-colors__item">
                                        <div class="source source-{{$j}} black" style="background-color: {{$image->color == 'sandstone' ?
                                        '#bd9e73' : ($image->color == 'grey' ?
                                         '#797979' : ($image->color == 'black' ?
                                          '#000' : ''))}};" id="black"></div>
                                    </div>
                                    <div hidden>{{$j++}}</div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        @if($category)
            <section class="description">
                <div class="text">
                    {!! $category !!}
                </div>
            </section>
        @endif
    </section>
@endsection
