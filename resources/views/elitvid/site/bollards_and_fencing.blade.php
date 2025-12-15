@extends('layouts.elitvid.elitvid')

@section('content')
    <main>
        @include('includes.elitvid.popup_call')
        @include('includes.elitvid.popup_application')
        @include('includes.elitvid.breadcrumbs')
        <section class="main">
            <div class="description">
                <div class="description-text">
                    <h1>{!! $staticPage->title ?? 'Болларды <br> и ограждения <br> из камня' !!}</h1>
                    <p>{!! $staticPage->description ?? 'Обладают противотаранными свойствами поэтому идеально подходят для защиты зданий и площадей. Есть возможность нанести орнамент или логотип на ваше изделие. А также же разместить металлическую вставку.' !!}</p>
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
                    <img src="{{asset($staticPage->main_image ?? '/elitvid_assets/newDesign/newDesign/imgs/bollards/main_bollards.png')}}" alt="{{$staticPage->alt_image ?? $static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/bollards/main_bollards.png'] ?? 'Болларды и ограждения'}}"
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
        <style>
            .text--description > h3 {
                font-size: 18px;
                font-family: "Montserrat-SemiBold";
                text-transform: revert;
            }
        </style>
        <section class="prev_direction">
            <h2>Формы каменных ограждений</h2>
            <div class="prev_directions__forms">
                <div class="prev_directions__form">
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/bollards/BL-1.png')}}" alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/bollards/BL-1.png']}}">
                    <div class="prev_directions_form--text">
                        <div class="text--description">
                            <h3>Боллард BL-1</h3>
                            <p>Защитный боллард</p>
                        </div>
                        <div class="lines-decor">
                            <div class="vertical-line"></div>
                            <div class="horizontal-line"></div>
                        </div>
                    </div>
                    <div class="submit-application">
                        <button class="submit-application--button open_popup_application">
                            Оставить заявку
                        </button>
                    </div>
                </div>
                <div class="prev_directions__form">
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/bollards/BL-2.png')}}" alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/bollards/BL-2.png']}}">
                    <div class="prev_directions_form--text">
                        <div class="text--description">
                            <h3>Боллард BL-2</h3>
                            <p>Защитный боллард</p>
                        </div>
                        <div class="lines-decor">
                            <div class="vertical-line"></div>
                            <div class="horizontal-line"></div>
                        </div>
                    </div>
                    <div class="submit-application">
                        <button class="submit-application--button open_popup_application">
                            Оставить заявку
                        </button>
                    </div>
                </div>
                <div class="prev_directions__form">
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/bollards/BL-3.png')}}" alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/bollards/BL-3.png']}}">
                    <div class="prev_directions_form--text">
                        <div class="text--description">
                            <h3>Боллард BL-3</h3>
                            <p>Защитный боллард</p>
                        </div>
                        <div class="lines-decor">
                            <div class="vertical-line"></div>
                            <div class="horizontal-line"></div>
                        </div>
                    </div>
                    <div class="submit-application">
                        <button class="submit-application--button open_popup_application">
                            Оставить заявку
                        </button>
                    </div>
                </div>
                <div class="prev_directions__form">
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/bollards/BL-4.png')}}" alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/bollards/BL-4.png']}}">
                    <div class="prev_directions_form--text">
                        <div class="text--description">
                            <h3>Боллард BL-4</h3>
                            <p>Защитный боллард</p>
                        </div>
                        <div class="lines-decor">
                            <div class="vertical-line"></div>
                            <div class="horizontal-line"></div>
                        </div>
                    </div>
                    <div class="submit-application">
                        <button class="submit-application--button open_popup_application">
                            Оставить заявку
                        </button>
                    </div>
                </div>
                <div class="prev_directions__form">
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/bollards/BL-5.png')}}" alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/bollards/BL-5.png']}}">
                    <div class="prev_directions_form--text">
                        <div class="text--description">
                            <h3>Боллард BL-5</h3>
                            <p>Защитный боллард</p>
                        </div>
                        <div class="lines-decor">
                            <div class="vertical-line"></div>
                            <div class="horizontal-line"></div>
                        </div>
                    </div>
                    <div class="submit-application">
                        <button class="submit-application--button open_popup_application">
                            Оставить заявку
                        </button>
                    </div>
                </div>
                <div class="prev_directions__form">
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/bollards/BL-6.png')}}" alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/bollards/BL-6.png']}}">
                    <div class="prev_directions_form--text">
                        <div class="text--description">
                            <h3>Боллард BL-6</h3>
                            <p>Защитный боллард</p>
                        </div>
                        <div class="lines-decor">
                            <div class="vertical-line"></div>
                            <div class="horizontal-line"></div>
                        </div>
                    </div>
                    <div class="submit-application">
                        <button class="submit-application--button open_popup_application">
                            Оставить заявку
                        </button>
                    </div>
                </div>
                <div class="prev_directions__form">
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/bollards/BL-7.png')}}" alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/bollards/BL-7.png']}}">
                    <div class="prev_directions_form--text">
                        <div class="text--description">
                            <h3>Боллард BL-7</h3>
                            <p>Защитный боллард</p>
                        </div>
                        <div class="lines-decor">
                            <div class="vertical-line"></div>
                            <div class="horizontal-line"></div>
                        </div>
                    </div>
                    <div class="submit-application">
                        <button class="submit-application--button open_popup_application">
                            Оставить заявку
                        </button>
                    </div>
                </div>
                <div class="prev_directions__form">
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/bollards/BL-8.png')}}" alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/bollards/BL-8.png']}}">
                    <div class="prev_directions_form--text">
                        <div class="text--description">
                            <h3>Боллард BL-8</h3>
                            <p>Защитный боллард</p>
                        </div>
                        <div class="lines-decor">
                            <div class="vertical-line"></div>
                            <div class="horizontal-line"></div>
                        </div>
                    </div>
                    <div class="submit-application">
                        <button class="submit-application--button open_popup_application">
                            Оставить заявку
                        </button>
                    </div>
                </div>
            </div>
        </section>
        @if($bollards_and_fencing_images->first())
            <section class="works">
                <h2>Примеры работ</h2>
                <div class="works-examples">
                    <div class="main__slider swiper">
                        <!-- Additional required wrapper -->
                        <div class="main-swiper-wrapper__slider swiper-wrapper">
                            <!-- Slides -->
                            @foreach($bollards_and_fencing_images as $item)
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
                            @foreach($bollards_and_fencing_images as $item)
                                @foreach($item->gallery_images as $image)
                                    <div class="swiper-slide"><img src="{{asset('storage/'.str_replace('public/','',$image->image))}}" alt="{{$image->description_image}}"></div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
        @if($category)
            <section class="description">
                <div class="text">
                    {!! $category !!}
                </div>
            </section>
        @endif
    </main>
@endsection
