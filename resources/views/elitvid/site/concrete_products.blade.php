@extends('layouts.elitvid.elitvid')

@section('content')
    <main>
        @include('includes.elitvid.popup_call')
        @include('includes.elitvid.popup_application')
        @include('includes.elitvid.breadcrumbs')
        <section class="main">
            <div class="description">
                <div class="description-text">
                    <h1>{!! $staticPage->title ?? 'Изделия из <br> бетона' !!}</h1>
                    <p>{!! $staticPage->description ?? 'Описание изделий из бетона' !!}</p>
                </div>
                <div class="submit-application">
                    <button class="submit-application--button open_popup_application">
                        Оставить заявку
                    </button>
                </div>
                {{--                @include('includes.elitvid.catalog_price_benches')--}}
            </div>
            <div class="stages">
                <div class="image">
                    <img src="{{asset($staticPage->main_image ?? '/elitvid_assets/newDesign/newDesign/imgs/concrete_products/concrete_products.webp')}}" alt="{{$staticPage->alt_image ?? $static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/concrete_products/concrete_products.webp'] ?? 'Изделия из бетона'}}"
                         class="main-page-up">
                    <div class="image-gradient-overlay"></div>
                </div>
                <div class="submit-application submit-application--mobile">
                    <button class="submit-application--button open_popup_application1 submit-application-button--mobile">
                        Оставить заявку
                    </button>
                </div>
                {{--                @include('includes.elitvid.mobile_catalog_price_benches')--}}
            </div>
        </section>
        @if($category)
            <section class="description">
                <div class="text">
                    {!! $category !!}
                </div>
            </section>
        @endif
        @if($concrete_products_images->first())
            <section class="works">
                <h2>Наши изделия из бетона</h2>
                <div class="works-examples">
                    <div class="main__slider swiper">
                        <!-- Additional required wrapper -->
                        <div class="main-swiper-wrapper__slider swiper-wrapper">
                            <!-- Slides -->
                            @foreach($concrete_products_images as $item)
                                @foreach($item->gallery_images as $image)
                                    <div class="swiper-slide"><img src="{{asset('storage/'.str_replace('public/','',$image->image))}}" alt="{{$image->description_image}}"></div>
                                @endforeach
                            @endforeach
                        </div>

                        <!-- If we need navigation buttons -->
                        <div class="swiper-button-prev arrow-left arrow">
                            <svg width="12" height="18" viewBox="0 0 12 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path id="Line 1" d="M9.54419 1.5L2.45559 9L9.54419 16.5" stroke="white" stroke-width="2.99575"
                                      stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="swiper-button-next arrow-right arrow">
                            <svg width="12" height="18" viewBox="0 0 12 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path id="Line 1" d="M2.45581 1.5L9.54441 9L2.45581 16.5" stroke="white" stroke-width="2.99575"
                                      stroke-linecap="round"/>
                            </svg>
                        </div>

                    </div>
                    <div class="thumbs__slider swiper">
                        <!-- Additional required wrapper -->
                        <div class="main-swiper-wrapper__slider swiper-wrapper">
                            <!-- Slides -->
                            @foreach($concrete_products_images as $item)
                                @foreach($item->gallery_images as $image)
                                    <div class="swiper-slide"><img src="{{asset('storage/'.str_replace('public/','',$image->image))}}" alt="{{$image->description_image}}"></div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </main>
@endsection
