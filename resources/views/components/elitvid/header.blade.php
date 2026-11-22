@php
    $current = request()->route()?->getName();
@endphp
<header class="rd-header">
    <div class="rd-header__bar">
        <a class="rd-header__logo" href="{{ route('home') }}">
            <img src="{{ asset('/elitvid_assets/newDesign/newDesign/imgs/logo/logo.svg') }}" alt="Элитвид" width="48" height="44">
        </a>
        {{-- на компьютере обёртка не влияет на раскладку; на мобильном это выпадающая панель меню --}}
        <div class="rd-header__nav">
        <ul class="rd-header__menu">
            <li><a href="{{ route('home') }}" @class(['is-current' => $current === 'home'])>Главная</a></li>
            <li><a href="{{ route('directions') }}" @class(['is-current' => $current === 'directions'])>Каталог</a></li>
            <li><a href="{{ route('blog_posts') }}" @class(['is-current' => $current === 'blog_posts'])>Блог</a></li>
            <li class="rd-header__contacts">
                <button class="rd-header__contacts-toggle" type="button">Контакты</button>
                <div class="rd-header__contacts-panel">
                    <a href="mailto:el_vid@mail.ru">el_vid@mail.ru</a>
                    <div class="rd-header__phones">
                        <a href="tel:+79104184777">+7 (910) 418 47 77</a>
                        <a href="tel:+79190409605">+7 (919) 040 96 05</a>
                        <a href="tel:+375297665012">+375 (29) 766 50 12</a>
                        <a href="tel:+375297034014">+375 (29) 703 40 14</a>
                    </div>
                </div>
            </li>
        </ul>
        <div class="rd-header__actions">
            <a class="rd-btn rd-btn--ghost js-cart-link" href="{{ route('cart.show') }}">Корзина</a>
            <button class="rd-btn rd-btn--light open_popup_application" type="button">Оставить заявку</button>
        </div>
        </div>
        <button class="rd-header__burger" type="button" aria-label="Меню">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>
