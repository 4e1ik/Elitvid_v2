@extends('layouts.elitvid.elitvid')

@section('body-class', 'rd-page')

@section('content')
    <main>
        @include('includes.elitvid.popup_application')
        <section class="rd-hero">
            <div class="rd-wrap">
                <h1>Изделия из полистоуна от производителя</h1>
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
                <img class="rd-why__photo" src="{{ asset('/elitvid_assets/redesign/images/why.webp') }}" alt="" width="288" height="219">
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
                <div class="rd-partners">
                    @foreach (['partner-a100' => 'A100', 'partner-belorusneft' => 'Белоруснефть', 'partner-bank' => 'Банк развития', 'partner-tobacco' => 'Табак-инвест', 'partner-vds' => 'VDS', 'partner-haven' => 'Зеленая гавань', 'partner-unisoil' => 'Юнисоил', 'partner-game' => 'Game Stream', 'partner-minsk' => 'Минскзеленстрой'] as $file => $name)
                        <img src="{{ asset("/elitvid_assets/redesign/images/{$file}.webp") }}" alt="{{ $name }}" width="163" height="87" loading="lazy">
                    @endforeach
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
                <section class="rd-section works">
                    <h2>Примеры работ</h2>
                    <div class="works-examples">
                        <div class="main__slider swiper">
                            <div class="main-swiper-wrapper__slider swiper-wrapper">
                                @foreach($pageContent->gallery->images as $image)
                                    <div class="swiper-slide"><img src="{{ asset('storage/'.str_replace('public/','',$image->image)) }}" alt="{{ $image->description_image ?? '' }}" loading="lazy"></div>
                                @endforeach
                            </div>
                            <div class="swiper-button-prev arrow-left arrow">
                                <svg width="12" height="18" viewBox="0 0 12 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path id="Line 1" d="M9.54419 1.5L2.45559 9L9.54419 16.5" stroke="white" stroke-width="2.99575" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="swiper-button-next arrow-right arrow">
                                <svg width="12" height="18" viewBox="0 0 12 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path id="Line 1" d="M2.45581 1.5L9.54441 9L2.45581 16.5" stroke="white" stroke-width="2.99575" stroke-linecap="round"/>
                                </svg>
                            </div>
                        </div>
                        <div class="thumbs__slider swiper">
                            <div class="main-swiper-wrapper__slider swiper-wrapper">
                                @foreach($pageContent->gallery->images as $image)
                                    <div class="swiper-slide"><img src="{{ asset('storage/'.str_replace('public/','',$image->image)) }}" alt="{{ $image->description_image ?? '' }}" loading="lazy"></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        </div>
    </main>
@endsection
