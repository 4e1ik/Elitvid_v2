<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link rel="shortcut icon" href="{{asset('/elitvid_assets/images/header/Logo_shortcut.png')}}">
    <link rel="stylesheet" href="{{asset('/elitvid_assets/reset.css')}}">

    <link rel="stylesheet" href="{{asset('/elitvid_assets/dist/style.css')}}">
    <link rel="stylesheet" href="{{asset('/elitvid_assets/dist/lightbox.css')}}">
    <title>Elitvid</title>
</head>
<body>
<header>
    <div class="container">
        <div class="header__main">
            <a href="{{route('home')}}" class="logo__header">
                <img class="logo__main" src="{{asset('/elitvid_assets/images/header/Logo_desktop.png')}}"
                     alt="Логотип Элитвид">
            </a>
            <a href="{{route('home')}}" class="logo__header-mobile">
                <img class="logo__main" src="{{asset('/elitvid_assets/images/header/Logo_shortcut.png')}}"
                     alt="Логотип Элитвид">
            </a>
            <nav class="header__menu">
                <div class="nav__burger">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="{{route('form')}}" class="phone-number">Заказать звонок</a>
                        </li>
{{--                        <li class="nav__item">--}}
{{--                            <a href="{{route('about')}}">О нас</a>--}}
{{--                        </li>--}}
                        <li class="nav__item">
                            <a href="{{route('catalog')}}">Каталог</a>
                            <ul class="nav__sublist">
                                <li>
                                    <a href="{{route('pots')}}">Кашпо</a>
                                    <ul class="nav__sublist">
                                        <li>
                                            <a href="{{route('square_pots')}}">Квадратные</a>
                                        </li>
                                        <li>
                                            <a href="{{route('round_pots')}}">Круглые</a>
                                        </li>
                                        <li>
                                            <a href="{{route('rectangular_pots')}}">Прямоугольные</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{route('benches')}}">Скамейки</a>
                                </li>
{{--                                <li>--}}
{{--                                    <a href="">Ротонды и коллонады</a>--}}
{{--                                </li>--}}
{{--                                <li>--}}
{{--                                    <a href="">Lorem ipsum.</a>--}}
{{--                                </li>--}}
{{--                                <li>--}}
{{--                                    <a href="">Lorem ipsum.</a>--}}
{{--                                </li>--}}
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <nav class="header__mobile-menu">
                <div class="nav__burger">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="">Меню</a>
                            <ul class="nav__sublist">
                                <li>
                                <li class="nav__item">
                                    <a href="">О нас</a>
                                </li>
                                <li class="nav__item">
                                    <a href="{{route('catalog')}}">Каталог</a>
                                    <ul class="nav__sublist">
                                        <li>
                                            <a href="{{route('pots')}}">Кашпо</a>
                                            <ul class="nav__sublist">
                                                <li>
                                                    <a href="{{route('square_pots')}}">Квадратные</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('round_pots')}}">Круглые</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('rectangular_pots')}}">Прямоугольные</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="{{route('benches')}}">Скамейки</a>
                                        </li>
                                        <li>
                                            <a href="">Ротонды и коллонады</a>
                                        </li>
                                        <li>
                                            <a href="">Lorem ipsum.</a>
                                        </li>
                                        <li>
                                            <a href="">Lorem ipsum.</a>
                                        </li>
                                    </ul>
                                </li>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>

@yield('content')

<footer>
    <div class="container">
        <div class="footer__main">
            <div class="footer__line">
                <div class="footer__line-item"></div>
            </div>
            <div class="footer__main-items">
                <div class="footer__logo">
                    <a href="">
                        <img class="logo__main" src="{{asset('/elitvid_assets/images/header/Logo_desktop.png')}}"
                             alt="Логотип Элитвид">
                    </a>
                    <p>Воплотим ваши идеи в реальность!</p>
                </div>
                <div class="footer__menu">
                    <div class="footer__contact">
                        <h4>Связаться с нами</h4>
                        <div class="footer__number">
                            <div class="footer__icons">
                                <img src="{{asset('/elitvid_assets/images/main/icons/viber-icon.png')}}"
                                     alt="Картинка вайбер">
                                <img src="{{asset('/elitvid_assets/images/main/icons/telegram-icon.png')}}"
                                     alt="Картинка телеграм">
                                <img src="{{asset('/elitvid_assets/images/main/icons/whatsapp-icon.png')}}"
                                     alt="Картинка вотсап">
                            </div>
                            <a href="tel:375297034014" class="phone-number">+375 29 703-40-14</a>
                        </div>
                        <div class="footer__number">
                            <div class="footer__icons">
                                <img src="{{asset('/elitvid_assets/images/main/icons/viber-icon.png')}}"
                                     alt="Картинка вайбер">
                                <img src="{{asset('/elitvid_assets/images/main/icons/telegram-icon.png')}}"
                                     alt="Картинка телеграм">
                                <img src="{{asset('/elitvid_assets/images/main/icons/whatsapp-icon.png')}}"
                                     alt="Картинка вотсап">
                            </div>
                            <a href="tel:375297665012" class="phone-number">+375 29 766-50-12</a>
                        </div>
                        <div class="footer__social-media">
                            <div class="footer__social-media_item">
                                <a href="https://www.instagram.com/elitvid/">
                                    <div class="footer__social-media_icon">
                                        <img src="{{asset('/elitvid_assets/images/main/icons/instagram-icon.png')}}"
                                             alt="Картинка Instagram">
                                    </div>
                                    <p>Instagram</p>
                                </a>
                            </div>
                            <div class="footer__social-media_item">
                                <a href="https://www.facebook.com/profile.php?id=100080874414368">
                                    <div class="footer__social-media_icon">
                                        <img src="{{asset('/elitvid_assets/images/main/icons/facebook-icon.png')}}"
                                             alt="Картинка Facebook">
                                    </div>
                                    <p>Facebook</p>
                                </a>
                            </div>
                            <div class="footer__social-media_item">
                                <a href="https://vk.com/elitvid">
                                    <div class="footer__social-media_icon">
                                        <img src="{{asset('/elitvid_assets/images/main/icons/vkontakte-icon.png')}}"
                                             alt="Картинка VKontakte">
                                    </div>
                                    <p>VKontakte</p>
                                </a>
                            </div>
                        </div>
                        <h5>Наша электронная почта</h5>
                        <div class="footer__mail_item">
                            <div class="footer__mail_icon">
                                <img src="{{asset('/elitvid_assets/images/main/icons/mail-icon.png')}}"
                                     alt="Картинка почта">
                            </div>
                            <p>el_vid@mail.ru</p>
                        </div>
                    </div>
                    <div class="footer__catalog">
                        <h4>Каталог</h4>
                        <nav>
                            <ul class="footer__nav-list">
                                <li class="nav__item">
                                    <a href="{{route('pots')}}">Кашпо</a>
                                </li>
                                <li class="nav__item">
                                    <a href=""{{route('benches')}}">Скамейки</a>
                                </li>
{{--                                <li class="nav__item">--}}
{{--                                    <a href="">Ротонды</a>--}}
{{--                                </li>--}}
{{--                                <li class="nav__item">--}}
{{--                                    <a href="">Lorem ipsum.</a>--}}
{{--                                </li>--}}
{{--                                <li class="nav__item">--}}
{{--                                    <a href="">Lorem ipsum.</a>--}}
{{--                                </li>--}}
                            </ul>
                        </nav>
                    </div>
                    <div class="footer__working-time">
                        <h4>Время работы</h4>
                        <p>8:00 - 17:00 (пн.-пт.)</p>
                    </div>
                </div>
            </div>
            <div class="developed">
                <h5>
                    <a href="https://4e1ik.github.io/Portfolio/src/index.html">Developed by Artemi Sevostian</a>
                </h5>
            </div>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script src="{{asset('/elitvid_assets/scripts/form.js')}}"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script src="https://www.google.com/recaptcha/api.js?render={{config('services.recaptcha.site_key')}}"></script>
@if(\Illuminate\Support\Facades\Route::currentRouteName() == 'home')
    <script src="{{asset('/elitvid_assets/scripts/swiper.js')}}"></script>
    <script src="{{asset('/elitvid_assets/scripts/script.js')}}"></script>
@else
    <script src="{{asset('/elitvid_assets/scripts/swiper-product.js')}}"></script>
    <script src="{{asset('/elitvid_assets/scripts/lightbox-plus-jquery.js')}}"></script>
@endif
<script>
    function onClick(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
            grecaptcha.execute('{{config('services.recaptcha.site_key')}}', {action: 'send_mail'}).then(function(token) {
                document.getElementById('g-recaptcha-response').value = token;
                document.getElementById('mail-form').submit();
            });
        });
    }
</script>
</body>
</html>
