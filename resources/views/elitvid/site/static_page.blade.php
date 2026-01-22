@extends('layouts.elitvid.elitvid')

@section('content')
    <main>
        @include('includes.elitvid.popup_call')
        @include('includes.elitvid.popup_application')
        @include('includes.elitvid.breadcrumbs')
        <section class="main">
            <div class="description">
                <div class="description-text">
                    <h1>{!! $staticPage->title ?? 'Заголовок новой статической страницы' !!}</h1>
                    <p>{!! $staticPage->subtitle ?? 'Описание новой статической страницы'!!}</p>
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
                    <img src="{{asset('/storage/'.str_replace('public/','',$staticPage->images()->where('main_image', true)->first()->image) ?? '')}}"
                         alt="{{$staticPage->images()->where('main_image', true)->first()->image ?? 'Описание главной старницы статической стараницы'}}"
                         class="main-page-up" loading="lazy">
                    <div class="image-gradient-overlay"></div>
                </div>
                <div class="submit-application submit-application--mobile">
                    <button class="submit-application--button open_popup_application1 submit-application-button--mobile">
                        Оставить заявку
                    </button>
                </div>
            </div>
        </section>
        @if($staticPage->content)
            <section class="description description-products">
                <div class="text">
                    {!! $staticPage->content !!}
                </div>
            </section>
        @endif
{{--        @if($staticPageGalleryQuery->first())--}}
            <section class="works">
                <h2>Примеры работ</h2>
                <div class="works-examples">
                    <div class="main__slider swiper">
                        <!-- Additional required wrapper -->
                        <div class="main-swiper-wrapper__slider swiper-wrapper">
                            <!-- Slides -->
{{--                            @foreach($rotundas_and_colonnades_images as $item)--}}
                                @foreach($staticPage->images()->where('main_image', '!=', true)->where('menu_image', '!=', true)->get() as $image)
                                    <div class="swiper-slide"><img src="{{asset('storage/'.str_replace('public/','',$image->image))}}" alt="{{$image->description_image}}" loading="lazy"></div>
                                @endforeach
{{--                            @endforeach--}}
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
{{--                            @foreach($rotundas_and_colonnades_images as $item)--}}
                                @foreach($staticPage->images()->where('main_image', '!=', true)->where('menu_image', '!=', true)->get() as $image)
                                    <div class="swiper-slide"><img src="{{asset('storage/'.str_replace('public/','',$image->image))}}" alt="{{$image->description_image}}" loading="lazy"></div>
                                @endforeach
{{--                            @endforeach--}}
                        </div>
                    </div>
                </div>
            </section>
{{--        @endif--}}
    </main>
@endsection
