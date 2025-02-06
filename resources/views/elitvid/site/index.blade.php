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
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/main_page_up.png')}}"
                         alt="Фотография три кашпо в ряд"
                         class="main-page-up">
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
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/main_page_center.png')}}"
                         alt="Фотография кашпо по центру"
                         class="main-page-center">
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
                                    alt=""></div>
                        <div class="swiper-slide"><img
                                    src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/a100.jpg')}}"
                                    alt=""></div>
                        <div class="swiper-slide"><img
                                    src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/Belorusneft.jpg')}}"
                                    alt=""></div>
                        <div class="swiper-slide"><img
                                    src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/development_bank.jpg')}}"
                                    alt=""></div>
                        <div class="swiper-slide"><img
                                    src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/green_haven.jpg')}}"
                                    alt=""></div>
                        <div class="swiper-slide"><img
                                    src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/tobacco_invest.jpg')}}"
                                    alt=""></div>
                        <div class="swiper-slide"><img
                                    src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/unisoil.jpg')}}"
                                    alt=""></div>
                        <div class="swiper-slide"><img
                                    src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/partners/vds.jpg')}}"
                                    alt=""></div>
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
            <div class="directions">
                <style>
                    h3 {
                        font-size: 1em;
                        font-family: "Merriweather";
                        text-transform: uppercase;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        font-weight: normal;
                    }

                    h3 button {
                        font-family: "Montserrat-Medium";
                        color: #FFFFFF;
                        margin-top: 1.5em;
                        width: 22.9375em;
                        height: 3.875em;
                        padding: 0.625em 0;
                        border-radius: 8px;
                        border: 1px solid #979797;
                        background: #22242A;
                        cursor: pointer;
                        transition: 0.2s;
                        text-transform: uppercase;
                    }
                </style>
                <div class="direction">
                    <div class="direction__image">
                        <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/pots.png')}} "
                             alt="Фотография направления кашпо">
                    </div>
                    <h3><a href="{{route('pots')}}">
                            <button>Кашпо</button>
                        </a></h3>
                </div>
                <style>
                    .slogan__direction .slogan__direction-text .h4 {
                        font-size: 1.125em;
                        font-family: 'Montserrat-SemiBold';
                    }

                    h3 > a {
                        width: 100%;
                    }
                </style>
                <div class="slogan__direction">
                    <div class="slogan__direction-text">
                        <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/img.png')}}" alt="">
                        <div class="h4">Мы воплотим в реальность любую вашу идею!</div>
                        <p>Работаем по индивидуальным размерам, эскизам и чертежам. Гарантируем качественное и
                            профессиональное
                            выполнение проекта. Наш опыт и знания позволяют реализовывать сложные и оригинальные задачи.
                            Мы
                            осуществляем доставку в разные страны и стремимся к долгосрочному сотрудничеству. Доверьте
                            нам
                            свои
                            идеи, и мы поможем воплотить их в жизнь.</p>
                    </div>

                </div>
                <div class="direction">
                    <div class="direction__image">
                        <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/benches.png')}}"
                             alt="Фотография направления скамеек">
                    </div>
                    <h3>
                        <a href="{{route('benches')}}">
                            <button>Скамьи</button>
                        </a>
                    </h3>
                </div>
                <div class="direction">
                    <div class="direction__image">
                        <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/rotundas.png')}}"
                             alt="Фотография направления ротонд и колонн">
                    </div>
                    <h3>
                        <a href="{{route('rotundas_and_colonnades')}}">
                            <button>Ротонды и колонны</button>
                        </a>
                    </h3>
                </div>
                <div class="direction">
                    <div class="direction__image">
                        <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/parklets.png')}}"
                             alt="Фотография направления парклетов и навесов">
                    </div>
                    <h3>
                        <a href="{{route('parklets_and_canopies')}}">
                            <button>Парклеты, навесы</button>
                        </a>
                    </h3>
                </div>
                <div class="direction">
                    <div class="direction__image">
                        <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/bollards.png')}}"
                             alt="Фотография направления боллард и ограждений">
                    </div>
                    <h3>
                        <a href="{{route('bollards_and_fencing')}}">
                            <button>Болларды и ограждения</button>
                        </a>
                    </h3>
                </div>
                <div class="direction">
                    <div class="direction__image">
                        <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/pillars.png')}}"
                             alt="Фотография направления столбов и накрывок">
                    </div>
                    <h3>
                        <a href="{{route('pillars_and_covers')}}">
                            <button>Столбы и накрывки</button>
                        </a>
                    </h3>
                </div>
                <div class="direction">

                    <div class="direction__image">
                        <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/facade_stucco.png')}}"
                             alt="Фотография направления фасадной лепнины и панелей">
                    </div>
                    <h3>
                        <a href="{{route('facade_stucco_molding_and_panels')}}">
                            <button>Фасадная лепнина и панели</button>
                        </a>
                    </h3>
                </div>
            </div>
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
                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/decor.png')}}"
                         alt="Картинка, описывающая декорации для продукции">
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
                                                alt="{{$image->description_image}}"></div>
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
                                                alt="{{$image->description_image}}"></div>
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
