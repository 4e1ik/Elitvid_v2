@php
    $current = request()->route()?->getName();
@endphp
<header class="rd-header">
    <div class="rd-header__bar">
        <a class="rd-header__logo" href="{{ route('home') }}">
            <img src="{{ asset('/elitvid_assets/newDesign/newDesign/imgs/logo/logo.svg') }}" alt="Элитвид" width="48" height="44">
        </a>
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
                        <a href="tel:+79100409605">+7 (910) 040 96 05</a>
                        <a href="tel:+375297665012">+375 (29) 766 50 12</a>
                        <a href="tel:+375297034014">+375 (29) 703 40 14</a>
                    </div>
                </div>
            </li>
        </ul>
        <div class="rd-header__actions">
            <button class="rd-btn rd-btn--ghost" type="button">Корзина</button>
            <button class="rd-btn rd-btn--light open_popup_application" type="button">Оставить заявку</button>
        </div>
        <button class="rd-header__burger" type="button" aria-label="Меню">
            <img src="{{ asset('/elitvid_assets/redesign/images/burger.svg') }}" alt="" width="21" height="21">
        </button>
    </div>
</header>
