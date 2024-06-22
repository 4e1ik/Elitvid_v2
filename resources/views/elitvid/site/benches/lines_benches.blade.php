
@extends('layouts.elitvid.elitvid')

@section('content')
    {{--    <section class="round-benchs__main section-item">--}}
    {{--        <div class="container">--}}
    {{--            <div class="square-benchs__main-header section-header">--}}
    {{--                <h2>Круглые кашпо</h2>--}}
    {{--            </div>--}}
    {{--            @include('includes.elitvid.catalog_price_benchs')--}}
    {{--            <div class="product__main-items">--}}
    {{--                @foreach($round_benchs as $bench)--}}
    {{--                    <div class="product__item-card">--}}
    {{--                        <a href="{{route('show_product', ['id' => $bench->id])}}">--}}
    {{--                            <div class="product__item-slider">--}}
    {{--                                <div class="swiper-product">--}}
    {{--                                    <div class="swiper-wrapper">--}}
    {{--                                        <!-- Slides -->--}}
    {{--                                        <div class="swiper-slide">--}}
    {{--                                            <img src="{{ asset('storage/'.$bench->images[0]->image) }}"--}}
    {{--                                                 alt="{{ $bench->images[0]->description_image }}">--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                            <div class="product__card-header">--}}
    {{--                                <p>{{$bench->title}}</p>--}}
    {{--                            </div>--}}
    {{--                        </a>--}}
    {{--                    </div>--}}
    {{--                @endforeach--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </section>--}}
    <main>
        @include('includes.elitvid.popup_call')
        @include('includes.elitvid.popup_application')
        @include('includes.elitvid.breadcrumbs')
        <section class="main">
            <div class="description">
                <div class="description-text">
                    <h1>Коллекция<br>lines</h1>
                    <p>Подходят для создания различных композиций в торговых центрах и на улице.</p>
                </div>
                <div class="submit-application">
                    <button class="submit-application--button open_popup_application">
                        Оставить заявку
                    </button>
                </div>
                <div class="download_catalog">
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M0.75 14.8545C0.948912 14.8545 1.13968 14.9335 1.28033 15.0742C1.42098 15.2148 1.5 15.4056 1.5 15.6045V19.3545C1.5 19.7523 1.65804 20.1338 1.93934 20.4152C2.22064 20.6965 2.60218 20.8545 3 20.8545H21C21.3978 20.8545 21.7794 20.6965 22.0607 20.4152C22.342 20.1338 22.5 19.7523 22.5 19.3545V15.6045C22.5 15.4056 22.579 15.2148 22.7197 15.0742C22.8603 14.9335 23.0511 14.8545 23.25 14.8545C23.4489 14.8545 23.6397 14.9335 23.7803 15.0742C23.921 15.2148 24 15.4056 24 15.6045V19.3545C24 20.1501 23.6839 20.9132 23.1213 21.4758C22.5587 22.0384 21.7956 22.3545 21 22.3545H3C2.20435 22.3545 1.44129 22.0384 0.87868 21.4758C0.316071 20.9132 0 20.1501 0 19.3545V15.6045C0 15.4056 0.0790176 15.2148 0.21967 15.0742C0.360322 14.9335 0.551088 14.8545 0.75 14.8545Z"
                                  fill="white"/>
                            <path d="M11.4699 17.7839C11.5396 17.8538 11.6224 17.9092 11.7135 17.947C11.8046 17.9848 11.9023 18.0043 12.0009 18.0043C12.0996 18.0043 12.1973 17.9848 12.2884 17.947C12.3795 17.9092 12.4623 17.8538 12.5319 17.7839L17.0319 13.2839C17.1728 13.1431 17.2519 12.9521 17.2519 12.7529C17.2519 12.5538 17.1728 12.3628 17.0319 12.2219C16.8911 12.0811 16.7001 12.002 16.5009 12.002C16.3018 12.002 16.1108 12.0811 15.9699 12.2219L12.7509 15.4424V2.25293C12.7509 2.05402 12.6719 1.86325 12.5313 1.7226C12.3906 1.58195 12.1999 1.50293 12.0009 1.50293C11.802 1.50293 11.6113 1.58195 11.4706 1.7226C11.33 1.86325 11.2509 2.05402 11.2509 2.25293V15.4424L8.03195 12.2219C7.89112 12.0811 7.70011 12.002 7.50095 12.002C7.30178 12.002 7.11078 12.0811 6.96995 12.2219C6.82912 12.3628 6.75 12.5538 6.75 12.7529C6.75 12.9521 6.82912 13.1431 6.96995 13.2839L11.4699 17.7839Z"
                                  fill="white"/>
                        </svg>
                        <p>Скачать каталог</p>
                    </a>
                </div>
            </div>
            <div class="stages">
                <div class="image">
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/benches/collections/lines/lines.png')}}" alt="Фотография три кашпо в ряд"
                         class="main-page-up">
                </div>
                <div class="submit-application submit-application--mobile">
                    <button class="submit-application--button open_popup_application1 submit-application-button--mobile">
                        Оставить заявку
                    </button>
                </div>
                <div class="download_catalog download_catalog--mobile">
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M0.75 14.8545C0.948912 14.8545 1.13968 14.9335 1.28033 15.0742C1.42098 15.2148 1.5 15.4056 1.5 15.6045V19.3545C1.5 19.7523 1.65804 20.1338 1.93934 20.4152C2.22064 20.6965 2.60218 20.8545 3 20.8545H21C21.3978 20.8545 21.7794 20.6965 22.0607 20.4152C22.342 20.1338 22.5 19.7523 22.5 19.3545V15.6045C22.5 15.4056 22.579 15.2148 22.7197 15.0742C22.8603 14.9335 23.0511 14.8545 23.25 14.8545C23.4489 14.8545 23.6397 14.9335 23.7803 15.0742C23.921 15.2148 24 15.4056 24 15.6045V19.3545C24 20.1501 23.6839 20.9132 23.1213 21.4758C22.5587 22.0384 21.7956 22.3545 21 22.3545H3C2.20435 22.3545 1.44129 22.0384 0.87868 21.4758C0.316071 20.9132 0 20.1501 0 19.3545V15.6045C0 15.4056 0.0790176 15.2148 0.21967 15.0742C0.360322 14.9335 0.551088 14.8545 0.75 14.8545Z"
                                  fill="white"/>
                            <path d="M11.4699 17.7839C11.5396 17.8538 11.6224 17.9092 11.7135 17.947C11.8046 17.9848 11.9023 18.0043 12.0009 18.0043C12.0996 18.0043 12.1973 17.9848 12.2884 17.947C12.3795 17.9092 12.4623 17.8538 12.5319 17.7839L17.0319 13.2839C17.1728 13.1431 17.2519 12.9521 17.2519 12.7529C17.2519 12.5538 17.1728 12.3628 17.0319 12.2219C16.8911 12.0811 16.7001 12.002 16.5009 12.002C16.3018 12.002 16.1108 12.0811 15.9699 12.2219L12.7509 15.4424V2.25293C12.7509 2.05402 12.6719 1.86325 12.5313 1.7226C12.3906 1.58195 12.1999 1.50293 12.0009 1.50293C11.802 1.50293 11.6113 1.58195 11.4706 1.7226C11.33 1.86325 11.2509 2.05402 11.2509 2.25293V15.4424L8.03195 12.2219C7.89112 12.0811 7.70011 12.002 7.50095 12.002C7.30178 12.002 7.11078 12.0811 6.96995 12.2219C6.82912 12.3628 6.75 12.5538 6.75 12.7529C6.75 12.9521 6.82912 13.1431 6.96995 13.2839L11.4699 17.7839Z"
                                  fill="white"/>
                        </svg>
                        <p>Скачать каталог</p>
                    </a>
                </div>
            </div>
        </section>
        <section class="not_main_page produce">
            <h2>Выберите форму</h2>
            <div class="not_main_page directions">
                @foreach($lines_benches as $product)
                    <div class="direction">
                        <img src="{{asset('storage/'.$product->bench_images[0]->image)}}" alt="Фотография направления">
                        <a href="{{route('show_bench_product', ['id' => $product->id])}}">
                            <button>{{$product->name}}</button>
                        </a>
                    </div>
                @endforeach
                {{--            <div class="direction">--}}
                {{--                <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/benchs/forms/circle_bench.png')}}" alt="Фотография направления кашпо">--}}
                {{--                <a href="">--}}
                {{--                    <button>Cylider</button>--}}
                {{--                </a>--}}
                {{--            </div>--}}
                {{--            <div class="direction">--}}
                {{--                <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/benchs/forms/circle_bench.png')}}" alt="Фотография направления кашпо">--}}
                {{--                <a href="">--}}
                {{--                    <button>Cylider</button>--}}
                {{--                </a>--}}
                {{--            </div>--}}
            </div>
        </section>
    </main>
@endsection
