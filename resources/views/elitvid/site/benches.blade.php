@extends('layouts.elitvid.elitvid')

@section('content')
    <main>
        @include('includes.elitvid.popup_call')
        @include('includes.elitvid.popup_application')
        @include('includes.elitvid.breadcrumbs')
        <section class="main">
            <div class="description">
                <div class="description-text">
                    <h1>Скамьи</h1>
                    <p>Доверьте нам свои идеи, и мы поможем Вам воплотить их в жизнь. Свяжитесь с нами сегодня и начните реализацию своего проекта!</p>
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
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/benches.png')}}" alt="Фотография три кашпо в ряд"
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
        <section class="prev_direction">
            <h2>Коллекции</h2>
            <div class="prev_directions__forms">
                <div class="prev_directions__form">
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/benches/collections/verona/main_verona.png')}}" alt="">
                    <div class="prev_directions_form--text">
                        <div class="text--description">
                            <h4>Verona</h4>
                            <p>Коллекция с потрясающими природными формами, гармонично впишется в любой ландшафт.</p>
                        </div>
                        <div class="lines-decor">
                            <div class="vertical-line"></div>
                            <div class="horizontal-line"></div>
                        </div>
                    </div>
                    <a href="{{route('verona_benches')}}">
                        <button class="look-collection">Смотреть коллекцию</button>
                    </a>
                </div>
                <div class="prev_directions__form">
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/benches/collections/stones/main_stones.png')}}" alt="">
                    <div class="prev_directions_form--text">
                        <div class="text--description">
                            <h4>Stones</h4>
                            <p>Идеальна для создания стильных пространств возле офисов и в парковых зонах.</p>
                        </div>
                        <div class="lines-decor">
                            <div class="vertical-line"></div>
                            <div class="horizontal-line"></div>
                        </div>
                    </div>
                    <a href="{{route('stones_benches')}}">
                        <button class="look-collection">Смотреть коллекцию</button>
                    </a>
                </div>
                <div class="prev_directions__form">
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/benches/collections/lines/main_lines.png')}}" alt="">
                    <div class="prev_directions_form--text">
                        <div class="text--description">
                            <h4>lines</h4>
                            <p>Подходят для создания различных композиций в торговых центрах и на улице.</p>
                        </div>
                        <div class="lines-decor">
                            <div class="vertical-line"></div>
                            <div class="horizontal-line"></div>
                        </div>
                    </div>
                    <a href="{{route('lines_benches')}}">
                        <button class="look-collection">Смотреть коллекцию</button>
                    </a>
                </div>
                <div class="prev_directions__form">
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/benches/collections/solo/main_solo.png')}}" alt="">
                    <div class="prev_directions_form--text">
                        <div class="text--description">
                            <h4>Solo</h4>
                            <p>Подойдёт для торговых центров, стильно впишется в любой дизайн-проект.</p>
                        </div>
                        <div class="lines-decor">
                            <div class="vertical-line"></div>
                            <div class="horizontal-line"></div>
                        </div>
                    </div>
                    <a href="{{route('solo_benches')}}">
                        <button class="look-collection">Смотреть коллекцию</button>
                    </a>
                </div>
                <div class="prev_directions__form">
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/benches/collections/street_furniture/main_street_furniture.png')}}" alt="">
                    <div class="prev_directions_form--text">
                        <div class="text--description">
                            <h4>Street furniture</h4>
                            <p>Удобна для детских площадок и аллей. Прекрасно впишется
                                в ваш уютный двор.</p>
                        </div>
                        <div class="lines-decor">
                            <div class="vertical-line"></div>
                            <div class="horizontal-line"></div>
                        </div>
                    </div>
                    <a href="{{route('street_furniture_benches')}}">
                        <button class="look-collection">Смотреть коллекцию</button>
                    </a>
                </div>
            </div>
        </section>
        @if($benches_images->first())
            <section class="works">
                <h2>Примеры работ</h2>
                <div class="works-examples">
                    <div class="main__slider swiper">
                        <!-- Additional required wrapper -->
                        <div class="main-swiper-wrapper__slider swiper-wrapper">
                            <!-- Slides -->
                            @foreach($benches_images as $item)
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
                            @foreach($benches_images as $item)
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
