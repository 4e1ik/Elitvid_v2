@extends('layouts.elitvid.elitvid')

@section('body-class', 'rd-page')

@section('content')
    <main>
        @include('includes.elitvid.popup_application')
        <section class="rd-hero">
            <div class="rd-wrap">
                <h1>Изделия из<br class="rd-br-wide"> полистоуна<br class="rd-br-wide"> от производителя</h1>
                <p>Наш опыт и знания позволяют нам реализовать самые сложные и оригинальные задачи по Вашим размерам, эскизам и чертежам.</p>
                <div class="rd-hero__photo" role="img" aria-label="Ротонда из полистоуна"></div>
                <p class="rd-stages"><span>Проектирование</span><span>Монтаж</span><span>Производство</span></p>
                <button class="rd-btn rd-btn--accent open_popup_application" type="button">Оставить заявку</button>
            </div>
        </section>

        <div class="rd-wrap">
            <section class="rd-section">
                <h2>Наши направления</h2>
                @include('includes.elitvid.redesign-directions')
            </section>
        </div>

        <section class="rd-why">
            <div class="rd-wrap">
                <div class="rd-why__text">
                    <h2>Почему выбирают изделия из полистоуна у нас?</h2>
                    <h3>Изготовление и производство по индивидуальному проекту заказчика.</h3>
                    <h3>Качественные материалы</h3>
                    <p>Полистоун — искусственный камень, современный инновационный материал, представляющий собой альтернативу натуральному камню.</p>
                    <h3>Преимущества изделий из полистоуна для городской среды:</h3>
                    <ul>
                        <li>позволяет воплощать современные дизайнерские идеи;</li>
                        <li>прочность и долговечность, антивандальные;</li>
                        <li>устойчивость к атмосферным воздействиям (влага, солнце, жара, холод);</li>
                        <li>устойчивость к микротрещинам в отличие от бетона;</li>
                        <li>устойчивость к органическим растворителям (ацетон, щёлочи, кислоты и др);</li>
                        <li>возможность нанесения орнамента и логотипа.</li>
                    </ul>
                </div>
                <img class="rd-why__photo" src="{{ asset('/elitvid_assets/redesign/images/why-mobile.webp') }}" alt="" width="288" height="219">
            </div>
        </section>

        <div class="rd-wrap">
            <section class="rd-stats" aria-label="Цифры">
                <div><strong>15 +</strong><span>лет на рынке</span></div>
                <div class="rd-stats__projects"><strong>120 +</strong><span>успешных проектов</span></div>
                <div class="rd-stats__clients"><strong>100 +</strong><span>довольных клиентов</span></div>
            </section>

            <section class="rd-section">
                <h2>Наши партнеры</h2>
                {{-- .partners__slider прокручивает main_slider.js (автопрокрутка без пауз, как на прежнем сайте) --}}
                <div class="rd-partners partners__slider swiper">
                    <div class="swiper-wrapper">
                        @foreach (['partner-a100' => 'A100', 'partner-belorusneft' => 'Белоруснефть', 'partner-bank' => 'Банк развития', 'partner-tobacco' => 'Табак-инвест', 'partner-vds' => 'VDS', 'partner-haven' => 'Зеленая гавань', 'partner-unisoil' => 'Юнисоил', 'partner-game' => 'Game Stream', 'partner-minsk' => 'Минскзеленстрой'] as $file => $name)
                            <div class="swiper-slide">
                                <img src="{{ asset("/elitvid_assets/redesign/images/{$file}.webp") }}" alt="{{ $name }}" width="163" height="87">
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="rd-section rd-split">
                <div>
                    <h2>Возможность нанесения логотипов и декоративных элементов на изделия</h2>
                    <p><strong>Изготовление и производство по индивидуальному проекту заказчика.</strong></p>
                    <p>Есть возможность нанести орнамент или логотип на ваше изделие. А так же разместить металлическую вставку.</p>
                    <p>Полистоун — искусственный камень, современный инновационный материал, представляющий собой альтернативу натуральному камню.</p>
                    <a class="rd-btn rd-btn--accent" href="{{ route('decorations') }}">Подробнее</a>
                </div>
                <img class="rd-ornament" src="{{ asset('/elitvid_assets/redesign/images/ornament.webp') }}" alt="" width="570" height="375" loading="lazy">
            </section>

            <section class="rd-section">
                <h2>Наши работы</h2>
                <iframe class="rd-video" src="https://www.youtube.com/embed/ziCM3lxEoOQ" title="Наши работы" loading="lazy"></iframe>
            </section>

            @if(isset($pageContent->gallery) && $pageContent->gallery->active)
                <x-elitvid.works title="Больше примеров" :images="$pageContent->gallery->images" />
            @endif
        </div>
    </main>
@endsection
