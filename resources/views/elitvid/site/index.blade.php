@extends('layouts.elitvid.elitvid')

@section('content')
<section class="swiper__main">
    <div class="container">
        <h1 class="visibility-hidden">Cлайдер с примерами работ</h1>
        <div class="swiper">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                <div class="swiper-slide">
                    <img src="{{asset('/elitvid_assets/images/main/slider/benches.png')}}" alt="Картинка скамейки с подсветкой">
                </div>
                <div class="swiper-slide">
                    <img src="{{asset('/elitvid_assets/images/main/slider/pots.png')}}" alt="Картинка кашпо из бетона">
                </div>
                <div class="swiper-slide">
                    <img src="{{asset('/elitvid_assets/images/main/slider/benches2.png')}}" alt="Картинка скамейки с подсветкой">
                </div>
                <div class="swiper-slide">
                    <img src="{{asset('/elitvid_assets/images/main/slider/house3.png')}}" alt="Картинка фасадная архитектура">
                </div>
                <div class="swiper-slide">
                    <img src="{{asset('/elitvid_assets/images/main/slider/Collonade.png')}}" alt="Картинка коллонада">
                </div>
                <div class="swiper-slide">
                    <img src="{{asset('/elitvid_assets/images/main/slider/house2.png')}}" alt="Картинка фасадная архитектура">
                </div>
                <div class="swiper-slide">
                    <img src="{{asset('/elitvid_assets/images/main/slider/house1.png')}}" alt="Картинка фасадная архитектура">
                </div>
            </div>
        </div>
        <div class="swiper__text">
            <div class="swiper__text-main">
                <h1>
                    Малые архитектурные формы, <br> скамейки и кашпо из полистоуна
                </h1>
                <h2 style="text-align: center;">
                    проектирование &#8226 производство &#8226 монтаж
                </h2>
            </div>
            <dl>
                <div class="swiper__text-count">
                    <div class="text-count__item">
                        <dt><span id="years">15</span>+</dt>
                        <dd>Лет на рынке</dd>
                    </div>
                    <div class="text-count__item">
                        <dt><span id="projects">120</span>+</dt>
                        <dd>Успешных проектов</dd>
                    </div>
                    <div class="text-count__item">
                        <dt><span id="clients">100</span>+</dt>
                        <dd>Довольных клинетов</dd>
                    </div>
                </div>
            </dl>
        </div>
    </div>
</section>

@include('includes.elitvid.catalog')

<section class="offer__main section-item">
    <div class="container">
        <div class="offer__main-header section-header">
            <h2>Наш проект</h2>
        </div>
        <div class="video__main-items">
            <video src="{{asset('/elitvid_assets/video/project.mp4')}}"
                   controls poster="{{asset('/elitvid_assets/images/main/slider/pots.png')}}"></video>
        </div>
    </div>
</section>
@endsection
