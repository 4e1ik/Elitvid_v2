@extends('layouts.elitvid.elitvid')

@section('content')
    <main>
        {{--        @include('includes.elitvid.popup_call')--}}
        @include('includes.elitvid.popup_application')
        <section class="main">
            <div class="description">
                <div class="description-text">
                    <h1>Изделия из полистоуна <br>от производителя</h1>
                    <p>Наш опыт и знания позволяют нам реализовать самые сложные и
                        оригинальные задачи по Вашим размерам, эскизам и чертежам.</p>
                </div>
                <div class="submit-application">
                    <button class="submit-application--button open_popup_application">
                        Оставить заявку
                    </button>
                </div>
                <div class="vertical-line--decor">
                    <div class="line"></div>
                </div>
            </div>
            <div class="stages">
                <div class="image">
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/main_page_up.webp')}}"
                         alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/main_page/main_page_up.webp'] ?? ''}}"
                         class="main-page-up" loading="lazy">
                </div>
                <div class="stages--text">
                    <p>Проектирование</p>
                    <div class="vertical-line"></div>
                    <p>Производство</p>
                    <div class="vertical-line"></div>
                    <p>Монтаж</p>
                </div>
                <div class="submit-application submit-application--mobile">
                    <button class="submit-application--button open_popup_application1 submit-application-button--mobile">
                        Оставить заявку
                    </button>
                </div>
            </div>
        </section>
        <section class="advantages">
            <div class="lines-decor">
                <div class="horizontal-line--decor"></div>
                <div class="vertical-line--decor"></div>
            </div>
            <div class="description">
                <div class="image">
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/main_page_center.webp')}}"
                         alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/main_page/main_page_center.webp'] ?? ''}}"
                         class="main-page-center" loading="lazy">
                </div>
                <div class="description-text">
                    <h2>Почему выбирают изделия из полистоуна у нас?</h2>
                    <h4>Изготовление и производство по индивидуальному проекту заказчика.</h4>
                    <div class="description-text--materials">
                        <h4>Качественные материалы</h4>
                        <p>Полистоун - искусственный камень, современный иновационный материал,
                            представляющий собой альтернативу натуральному камню.</p>
                    </div>
                    <div class="description-text--advantages">
                        <h4>Преимущества изделий из полистоуна для городской среды:</h4>
                        <ul>
                            <li>позволяет воплощать современные дизайнерские идеи;</li>
                            <li>прочность и долговечность, антивандальные;</li>
                            <li>устойчивость к атмосферным воздействиям (влага, солнце, жара, холод);</li>
                            <li>устойчивость к микротрещинам в отличие от бетона;</li>
                            <li>устойчивость к органическим растворителям (ацетон, щёлочи, кислоты и др)</li>
                            <li>возможность нанесения орнамента и логотипа.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <style>
                .company-advantages .advantage .h3 {
                    font-size: 1.75em;
                    font-family: 'Merriweather';
                    text-transform: uppercase;
                }
            </style>
            <div class="company-advantages">
                <div class="advantage">
                    <div class="h3">15 +</div>
                    <p>лет на рынке</p>
                </div>
                <div class="advantage">
                    <div class="h3">120 +</div>
                    <p>успешных проектов</p>
                </div>
                <div class="advantage">
                    <div class="h3">100 +</div>
                    <p>довольных клиентов</p>
                </div>
            </div>
        </section>
        <section class="partners">
            <h2>Наши партнеры</h2>
            <div class="partners_slider">
                <div class="partners__slider swiper">
                    <!-- Additional required wrapper -->
                    <div class="partners-swiper-wrapper__slider swiper-wrapper">
                        <!-- Slides -->
                        <div class="swiper-slide"><img
                                    src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/game_stream.jpg')}}"
                                    alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/game_stream.jpg'] ?? ''}}" loading="lazy"></div>
                        <div class="swiper-slide"><img
                                    src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/a100.jpg')}}"
                                    alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/a100.jpg'] ?? ''}}" loading="lazy"></div>
                        <div class="swiper-slide"><img
                                    src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/Belorusneft.jpg')}}"
                                    alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/Belorusneft.jpg'] ?? ''}}" loading="lazy"></div>
                        <div class="swiper-slide"><img
                                    src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/development_bank.jpg')}}"
                                    alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/development_bank.jpg'] ?? ''}}" loading="lazy"></div>
                        <div class="swiper-slide"><img
                                    src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/green_haven.jpg')}}"
                                    alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/green_haven.jpg'] ?? ''}}" loading="lazy"></div>
                        <div class="swiper-slide"><img
                                    src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/tobacco_invest.jpg')}}"
                                    alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/tobacco_invest.jpg'] ?? ''}}" loading="lazy"></div>
                        <div class="swiper-slide"><img
                                    src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/unisoil.jpg')}}"
                                    alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/unisoil.jpg'] ?? ''}}" loading="lazy"></div>
                        <div class="swiper-slide"><img
                                    src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/vds.jpg')}}"
                                    alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/vds.jpg'] ?? ''}}" loading="lazy"></div>
                    </div>
                </div>
            </div>
            <div class="lines-decor">
                <div class="horizontal-line--decor"></div>
                <div class="vertical-line--decor"></div>
            </div>
        </section>
        <section class="produce">
            <h2>Каталог изделий из полистоуна</h2>
            @include('includes.elitvid.directions')
        </section>
        <section class="decorative_elements">
            <div class="lines-decor">
                <div class="vertical-line--decor"></div>
                <div class="horizontal-line--decor"></div>
                <div class="vertical-line-2--decor"></div>
            </div>
            <div class="decorative_elements__main">
                <div class="decorative_elements__description">
                    <div class="elements_main__headers">
                        <h2>Декоративные элементы из полистоуна</h2>
                        <h4>Изготовление и производство по индивидуальному проекту заказчика.</h4>
                    </div>
                    <div class="elements_main__paragraphs">
                        <p>Есть возможность нанести орнамент или логотип на ваше изделие. А так же разместить
                            металлическую
                            вставку.</p>
                        <p>Полистоун - искусственный камень, современный иновационный материал, представляющий собой
                            альтернативу натуральному камню.</p>
                    </div>
                    <div class="elements_main__button">
                        <a href="{{route('decorations')}}">
                            <button>
                                ПОДРОБНЕЕ
                            </button>
                        </a>
                    </div>
                </div>
                <div class="decorative_elements__image">
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/decor.webp')}}"
                         alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/main_page/decor.webp'] ?? ''}}" loading="lazy">
                </div>
            </div>
        </section>
        <section class="works">
            <h2>Наши работы</h2>
            <div class="produce-video">
                <iframe src="https://www.youtube.com/embed/ziCM3lxEoOQ?si=Fz5sCstSasMpl0n4&amp;controls=0"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
            </div>
            @if($main_page_images->first())
                <div class="works-examples">
                    <div class="main__slider swiper">
                        <!-- Additional required wrapper -->
                        <div class="main-swiper-wrapper__slider swiper-wrapper">

                            <!-- Slides -->
                            @foreach($main_page_images as $item)
                                @foreach($item->gallery_images as $image)
                                    <div class="swiper-slide"><img
                                                src="{{asset('storage/'.str_replace('public/','',$image->image))}}"
                                                alt="{{$image->description_image}}" loading="lazy"></div>
                                @endforeach
                            @endforeach
                        </div>

                        <!-- If we need navigation buttons -->
                        <div class="swiper-button-prev arrow-left arrow">
                            <svg width="12" height="18" viewBox="0 0 12 18" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path id="Line 1" d="M9.54419 1.5L2.45559 9L9.54419 16.5" stroke="white"
                                      stroke-width="2.99575"
                                      stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="swiper-button-next arrow-right arrow">
                            <svg width="12" height="18" viewBox="0 0 12 18" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path id="Line 1" d="M2.45581 1.5L9.54441 9L2.45581 16.5" stroke="white"
                                      stroke-width="2.99575"
                                      stroke-linecap="round"/>
                            </svg>
                        </div>

                    </div>
                    <div class="thumbs__slider swiper">
                        <!-- Additional required wrapper -->
                        <div class="main-swiper-wrapper__slider swiper-wrapper">
                            <!-- Slides -->
                            @foreach($main_page_images as $item)
                                @foreach($item->gallery_images as $image)
                                    <div class="swiper-slide"><img
                                                src="{{asset('storage/'.str_replace('public/','',$image->image))}}"
                                                alt="{{$image->description_image}}" loading="lazy"></div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
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
