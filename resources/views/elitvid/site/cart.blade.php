@extends('layouts.elitvid.elitvid')

@section('content')
    @php
        $orderFailed = $errors->hasAny(['name', 'email', 'phone', 'name_corp', 'textarea', 'g-recaptcha-response']);
    @endphp
    <main>
        @include('includes.elitvid.popup_application')

        @if($canOrder)
            <div class="popup popup_order rd-form @if($orderFailed) is-open @endif">
                <div class="popup__body popup__body_order">
                    <form class="popup__form" id="order_form" action="{{ route('cart.place') }}" method="post">
                        @csrf
                        <div class="popup__cross popup__cross_order">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M3.21897 4.28097C3.14924 4.21124 3.09392 4.12846 3.05619 4.03735C3.01845 3.94624 2.99902 3.84859 2.99902 3.74997C2.99902 3.65135 3.01845 3.5537 3.05619 3.4626C3.09392 3.37149 3.14924 3.2887 3.21897 3.21897C3.2887 3.14924 3.37149 3.09392 3.4626 3.05619C3.5537 3.01845 3.65135 2.99902 3.74997 2.99902C3.84859 2.99902 3.94624 3.01845 4.03735 3.05619C4.12846 3.09392 4.21124 3.14924 4.28097 3.21897L12 10.9395L19.719 3.21897C19.7887 3.14924 19.8715 3.09392 19.9626 3.05619C20.0537 3.01845 20.1514 2.99902 20.25 2.99902C20.3486 2.99902 20.4462 3.01845 20.5373 3.05619C20.6285 3.09392 20.7112 3.14924 20.781 3.21897C20.8507 3.2887 20.906 3.37149 20.9438 3.4626C20.9815 3.5537 21.0009 3.65135 21.0009 3.74997C21.0009 3.84859 20.9815 3.94624 20.9438 4.03735C20.906 4.12846 20.8507 4.21124 20.781 4.28097L13.0605 12L20.781 19.719C20.8507 19.7887 20.906 19.8715 20.9438 19.9626C20.9815 20.0537 21.0009 20.1514 21.0009 20.25C21.0009 20.3486 20.9815 20.4462 20.9438 20.5373C20.906 20.6285 20.8507 20.7112 20.781 20.781C20.7112 20.8507 20.6285 20.906 20.5373 20.9438C20.4462 20.9815 20.3486 21.0009 20.25 21.0009C20.1514 21.0009 20.0537 20.9815 19.9626 20.9438C19.8715 20.906 19.7887 20.8507 19.719 20.781L12 13.0605L4.28097 20.781C4.21124 20.8507 4.12846 20.906 4.03735 20.9438C3.94624 20.9815 3.84859 21.0009 3.74997 21.0009C3.65135 21.0009 3.5537 20.9815 3.4626 20.9438C3.37149 20.906 3.2887 20.8507 3.21897 20.781C3.14924 20.7112 3.09392 20.6285 3.05619 20.5373C3.01845 20.4462 2.99902 20.3486 2.99902 20.25C2.99902 20.1514 3.01845 20.0537 3.05619 19.9626C3.09392 19.8715 3.14924 19.7887 3.21897 19.719L10.9395 12L3.21897 4.28097Z" fill="#7F7F7F"/>
                            </svg>
                        </div>
                        <div class="h2">Сформировать заявку</div>
                        <div class="popup__content">
                            <div class="popup_content__inputs">
                                <div class="popup__input">
                                    <p>Ваше имя</p>
                                    <input class="item-form name" type="text" name="name" value="{{ old('name') }}" placeholder="Имя*" required>
                                    <div class="form_error">
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="popup__input">
                                    <p>Ваш E-mail</p>
                                    <input class="item-form" type="text" name="email" value="{{ old('email') }}" placeholder="E-mail*" required>
                                    <div class="form_error">
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="popup__input country">
                                    <p>Номер телефона</p>
                                    <div class="poop">
                                        <select name="country">
                                            <option disabled>Выберите страну</option>
                                            <option class="by" @selected(old('country') === '🇧🇾 +375')>🇧🇾 +375</option>
                                            <option class="ru" @selected(old('country') === '🇷🇺 +7')>🇷🇺 +7</option>
                                            <option class="kz" @selected(old('country') === '🇰🇿 +7')>🇰🇿 +7</option>
                                        </select>
                                        <input class="item-form" type="text" name="phone" value="{{ old('phone') }}" required>
                                        <div class="form_error">
                                            @error('phone')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="popup__input name-corp">
                                    <p>Название организации</p>
                                    <input id="order-name-corp" class="item-form" type="text" name="name_corp" value="{{ old('name_corp') }}" placeholder="Название">
                                    <div class="form_error">
                                        @error('name_corp')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="popup_content_inputs__comment popup__input">
                                <p>Интересует что-то конкретное?</p>
                                <textarea class="item-form textarea" name="textarea" rows="5" placeholder="Ваш комментарий...">{{ old('textarea') }}</textarea>
                                <div class="form_error">
                                    @error('textarea')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <input type="hidden" name="g-recaptcha-response" id="order-recaptcha">
                            <div class="form_error">
                                @error('g-recaptcha-response')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="submit__button">
                                <button class="form__form-button" type="button" onclick="submitOrder(event)">Сформировать заявку</button>
                                <p>Отправляя заявку, вы даете согласие на обработку своих персональных данных в соответствии с Политикой конфиденциальности.</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <section class="breadcrumbs">
            <div class="breadcrumbs__links">
                <a href="{{ route('home') }}">Главная</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.64592 2.14689C4.69236 2.10033 4.74754 2.06339 4.80828 2.03818C4.86903 2.01297 4.93415 2 4.99992 2C5.06568 2 5.13081 2.01297 5.19155 2.03818C5.2523 2.06339 5.30747 2.10033 5.35392 2.14689L11.3539 8.14689C11.4005 8.19334 11.4374 8.24852 11.4626 8.30926C11.4878 8.37001 11.5008 8.43513 11.5008 8.50089C11.5008 8.56666 11.4878 8.63178 11.4626 8.69253C11.4374 8.75327 11.4005 8.80845 11.3539 8.85489L5.35392 14.8549C5.26003 14.9488 5.13269 15.0015 4.99992 15.0015C4.86714 15.0015 4.7398 14.9488 4.64592 14.8549C4.55203 14.761 4.49929 14.6337 4.49929 14.5009C4.49929 14.3681 4.55203 14.2408 4.64592 14.1469L10.2929 8.50089L4.64592 2.85489C4.59935 2.80845 4.56241 2.75327 4.5372 2.69253C4.512 2.63178 4.49902 2.56666 4.49902 2.50089C4.49902 2.43513 4.512 2.37001 4.5372 2.30926C4.56241 2.24852 4.59935 2.19334 4.64592 2.14689Z" fill="white"/>
                </svg>
                <p>Корзина</p>
            </div>
        </section>

        <section class="product cart-page">
            <h1>Корзина</h1>

            @if(session('success'))
                <p class="cart-page__note">{{ session('success') }}</p>
            @endif

            @error('cart')
                <p class="cart-page__note cart-page__note--bad">{{ $message }}</p>
            @enderror

            @if($lines === [])
                <p class="cart-page__note">Корзина пуста.</p>
            @else
                <div class="cart-page__lines">
                    @foreach($lines as $line)
                        <div class="cart-page__line">
                            <div>
                                <p class="cart-page__name">{{ $line['name'] }}</p>
                                @if(!$line['available'])
                                    <p class="cart-page__note cart-page__note--bad">Уберите этот товар, чтобы отправить заявку.</p>
                                @endif
                            </div>
                            <form class="cart-page__qty" method="post" action="{{ route('cart.update', $line['product_id']) }}">
                                @csrf
                                <button type="submit" name="quantity" value="{{ max($line['quantity'] - 1, 0) }}" aria-label="Уменьшить">−</button>
                                <span>{{ $line['quantity'] }}</span>
                                <button type="submit" name="quantity" value="{{ min($line['quantity'] + 1, 999) }}" aria-label="Увеличить">+</button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <div class="cart-page__actions">
                    <form method="post" action="{{ route('cart.clear') }}">
                        @csrf
                        <button class="cart-page__button cart-page__button--ghost" type="submit">Очистить корзину</button>
                    </form>
                    @if($canOrder)
                        <button class="cart-page__button open-order" type="button">Сформировать заявку</button>
                    @endif
                </div>
            @endif
        </section>
    </main>

    @if($canOrder)
        <script>
            async function submitOrder(event) {
                event.preventDefault();
                try {
                    const token = await new Promise((resolve, reject) => {
                        grecaptcha.ready(async () => {
                            try {
                                resolve(await grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {
                                    action: 'send_mail'
                                }));
                            } catch (error) {
                                reject(error);
                            }
                        });
                    });
                    document.getElementById('order-recaptcha').value = token;
                    document.getElementById('order_form').submit();
                } catch (error) {
                    alert('Не удалось пройти проверку. Попробуйте ещё раз.');
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                var popup = document.querySelector('.popup_order');
                var openButton = document.querySelector('.open-order');
                var cross = document.querySelector('.popup__cross_order');
                if (!popup) {
                    return;
                }

                function showOrder() {
                    var mail = document.querySelector('.popup_application');
                    if (mail) {
                        mail.style.display = 'none';
                    }
                    popup.style.display = 'block';
                    document.body.classList.add('popup-open');
                }

                function hideOrder() {
                    popup.style.display = 'none';
                    popup.classList.remove('is-open');
                    document.body.classList.remove('popup-open');
                }

                if (openButton) {
                    openButton.addEventListener('click', showOrder);
                }
                if (cross) {
                    cross.addEventListener('click', hideOrder);
                }
                popup.addEventListener('click', function (event) {
                    if (event.target === popup.querySelector('.popup__body_order')) {
                        hideOrder();
                    }
                });
                if (popup.classList.contains('is-open')) {
                    showOrder();
                }
            });
        </script>
    @endif
@endsection
