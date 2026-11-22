<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="yandex-verification" content="3d561315259a84fe"/>
    <!-- Preload критических ресурсов -->
    <link rel="preload" href="{{asset('/elitvid_assets/newDesign/newDesign/style.css')}}?v=1.8" as="style">
    <link rel="preload" href="{{asset('/elitvid_assets/newDesign/newDesign/imgs/logo/logo.svg')}}" as="image">
    <link rel="stylesheet" href="{{asset('/elitvid_assets/newDesign/newDesign/reset.css')}}">
    {{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>--}}
    <link rel="stylesheet" href="{{asset('/elitvid_assets/newDesign/newDesign/swiper.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('/elitvid_assets/newDesign/newDesign/swiper-bundle.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('/elitvid_assets/newDesign/newDesign/style.css')}}?v=1.8">
    <link rel="stylesheet" href="{{asset('/elitvid_assets/redesign/redesign.css')}}?v=3.3">

    {{--<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>--}}
    {{--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}
    <script defer src="{{asset('/elitvid_assets/newDesign/newDesign/js/jquery-3.7.1.min.js')}}"></script>
    <script defer src="{{asset('/elitvid_assets/newDesign/newDesign/js/jquery-migrate-1.4.1.min.js')}}"></script>
    <script defer src="{{asset('/elitvid_assets/newDesign/newDesign/swiper.min.js')}}"></script>
    <script defer src="{{asset('/elitvid_assets/newDesign/newDesign/swiper-bundle.min.js')}}"></script>
    <script defer src="{{asset('/elitvid_assets/newDesign/newDesign/js/sliders/main_slider.js')}}"></script>
    <script defer src="{{asset('/elitvid_assets/newDesign/newDesign/js/popupSubmitApplication.js')}}?v=1.1"></script>
    {{--<script defer src="{{asset('/elitvid_assets/newDesign/newDesign/js/popupRequestCall.js')}}"></script>--}}
    <script defer src="{{asset('/elitvid_assets/newDesign/newDesign/js/burgerMenu.js')}}"></script>
    <script defer src="{{asset('/elitvid_assets/newDesign/newDesign/js/imageUpdater.js')}}"></script>
    <script defer src="{{asset('/elitvid_assets/newDesign/newDesign/js/test.js')}}"></script>
    <script defer src="{{asset('/elitvid_assets/redesign/redesign.js')}}?v=1.5"></script>

    {{--    <link rel="shortcut icon" type="image/x-icon" href="{{asset('/elitvid_assets/newDesign/newDesign/imgs/logo/logo.svg')}}" >--}}
    {{--    <link rel="shortcut icon" href="{{asset('/favicon.ico')}}" sizes="16x16">--}}
    <link rel="shortcut icon" href="{{asset('/favicon2.webp')}}" sizes="67x67">
    {{--    <link rel="icon" type="image/svg+xml" href="{{asset('/favicon.svg')}}" sizes="16x16">--}}

    <title>@if(isset($pageContent) && $pageContent)
            {{$pageContent->meta_title ?? 'Изделия из полистоуна от производителя на заказ - Elitvid.com'}}
        @else
            {{$metaTitle ?? 'Изделия из полистоуна от производителя на заказ - Elitvid.com'}}
        @endif</title>
    <meta name="description"
          content="@if(isset($pageContent) && $pageContent){{ $pageContent->meta_description ?? 'Качественные изделия из полистоуна от производителя Elitvid.com. В нашем каталоге широкий выбор декоративных элементов для интерьера и экстерьера. Надежность, эстетика и доступные цены – только у нас!' }}@else{{ $metaDescription ?? 'Качественные изделия из полистоуна от производителя Elitvid.com. В нашем каталоге широкий выбор декоративных элементов для интерьера и экстерьера. Надежность, эстетика и доступные цены – только у нас!' }}@endif">
    @yield('404')
    @yield('cannonicalUrl')
</head>
<body class="@yield('body-class')">
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N2MNKNDW"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
<x-elitvid.header />

@yield('content')
<x-elitvid.footer />

<script async src="https://www.google.com/recaptcha/api.js?render={{config('services.recaptcha.site_key')}}"></script>
<script>
    {{--function onClick(e) {--}}
    {{--    e.preventDefault();--}}
    {{--    grecaptcha.ready(function () {--}}
    {{--        grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {action: 'send_mail'}).then(function (token) {--}}
    {{--            document.getElementById('g-recaptcha-response').value = token;--}}
    {{--            document.getElementById('mail_form').submit();--}}
    {{--        });--}}
    {{--    });--}}
    {{--}--}}
    async function onClick(e) {
        e.preventDefault();
        try {
            // Получаем токен reCAPTCHA
            const token = await new Promise((resolve, reject) => {
                grecaptcha.ready(async () => {
                    try {
                        const token = await grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {
                            action: 'send_mail'
                        });
                        resolve(token);
                    } catch (error) {
                        reject(error);
                    }
                });
            });

            // Устанавливаем токен в скрытое поле формы
            document.getElementById('g-recaptcha-response').value = token;

            // Отправляем форму через Fetch API
            const form = document.getElementById('mail_form');
            const formData = new FormData(form);

            const response = await fetch('/send_mail', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value
                }
            });

            const data = await response.json();

            if (!response.ok) {
                if (response.status === 422 && data.errors) {
                    // Ошибки валидации
                    showErrors(data.errors);
                } else {
                    // Другие ошибки
                    throw new Error(data.message || 'Произошла ошибка при отправке');
                }
                return;
            }

            // Успешная отправка
            // alert(data.message || 'Письмо успешно отправлено!');
            const currentUrl = window.location.href;
            window.location.href = `/thank_you?referrer=${encodeURIComponent(currentUrl)}`;

            form.reset(); // Сброс формы
            clearErrors(); // Очистка ошибок

        } catch (error) {
            // Обработка ошибок
            console.error('Ошибка:', error);
            alert(error.message || 'Произошла ошибка при отправке письма');
        }
    }

    // Функция для отображения ошибок
    function showErrors(errors) {
        // Очищаем предыдущие ошибки
        clearErrors();

        // Показываем новые ошибки
        Object.entries(errors).forEach(([field, messages]) => {
            // Ищем input или textarea по имени
            const inputOrTextarea = document.querySelector(`input[name="${field}"], textarea[name="${field}"]`);

            if (inputOrTextarea) {
                // Находим контейнер для ошибок
                const errorContainer = inputOrTextarea.closest('.popup__input')?.querySelector('.form_error');

                if (errorContainer) {
                    // Вставляем сообщения об ошибках
                    errorContainer.innerHTML = messages.map(message => `
                        <div class="text-danger">${message}</div>
                    `).join('');
                }

                if (field === 'name_corp') {
                    const name_corp = document.querySelector('.name-corp');
                    name_corp.classList.add('name-corp-error');
                }

                if (field === 'file') {
                    const name_corp = document.querySelector('.popup_content_inputs__file-button');
                    name_corp.classList.add('file-error');
                }
            }
        });
    }

    // Функция для очистки ошибок
    function clearErrors() {
        document.querySelectorAll('.form_error').forEach(el => el.innerHTML = '');
    }
</script>
<!-- Yandex Metrika -->
<script type="text/javascript">
    (function (m, e, t, r, i, k, a) {
        m[i] = m[i] || function () {
            (m[i].a = m[i].a || []).push(arguments)
        };
        m[i].l = 1 * new Date();
        for (var j = 0; j < document.scripts.length; j++) {
            if (document.scripts[j].src === r) {
                return;
            }
        }
        k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
    })
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(90164998, "init", {
        clickmap: true,
        trackLinks: true,
        accurateTrackBounce: true,
        webvisor: true
    });
</script>
<noscript>
    <div><img src="https://mc.yandex.ru/watch/90164998" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript>

<!-- Google Tag Manager -->
<script>(function (w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start':
                new Date().getTime(), event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-N2MNKNDW');</script>
<!-- End Google Tag Manager -->

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-27WP3P8931"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'G-27WP3P8931');
</script>
<script>
    var __widgetVer = "?v=" + Math.round(new Date().getMinutes() / 5);   (function (w, d, s, o, f, js, fjs) {
        w["Chat-Widget"] = o; w[o] = w[o] || function () { (w[o].q = w[o].q || []).push(arguments) };
        js = d.createElement(s), fjs = d.getElementsByTagName(s)[0];
        js.id = o; js.src = f; js.async = 1; fjs.parentNode.insertBefore(js, fjs);
    }(window, document, "script", "mw", "https://s2.writer-cloud.com/chat/widgetloader/widget-loader.js" + __widgetVer));

    var config = {
        urlToWidget: 'https://s2.writer-cloud.com/chat/widget/?token=elitvid-com-widget',
        urlToButtonCss: 'https://s2.writer-cloud.com/chat/widgetloader/flowerpot/css/button.css',
        customerId: 'flowerpot1775032341',
        popupMode: 'byUser'
    };

    mw(config);
</script>
</body>
</html>




