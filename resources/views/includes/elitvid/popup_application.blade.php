<div class="popup popup_application">
    <div class="popup__body popup__body_application">
        <form class="popup__form" action="{{route('send_mail')}}" method="post" enctype="multipart/form-data" id="mail_form">
            @csrf
            <div class="popup__cross popup__cross_application">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M3.21897 4.28097C3.14924 4.21124 3.09392 4.12846 3.05619 4.03735C3.01845 3.94624 2.99902 3.84859 2.99902 3.74997C2.99902 3.65135 3.01845 3.5537 3.05619 3.4626C3.09392 3.37149 3.14924 3.2887 3.21897 3.21897C3.2887 3.14924 3.37149 3.09392 3.4626 3.05619C3.5537 3.01845 3.65135 2.99902 3.74997 2.99902C3.84859 2.99902 3.94624 3.01845 4.03735 3.05619C4.12846 3.09392 4.21124 3.14924 4.28097 3.21897L12 10.9395L19.719 3.21897C19.7887 3.14924 19.8715 3.09392 19.9626 3.05619C20.0537 3.01845 20.1514 2.99902 20.25 2.99902C20.3486 2.99902 20.4462 3.01845 20.5373 3.05619C20.6285 3.09392 20.7112 3.14924 20.781 3.21897C20.8507 3.2887 20.906 3.37149 20.9438 3.4626C20.9815 3.5537 21.0009 3.65135 21.0009 3.74997C21.0009 3.84859 20.9815 3.94624 20.9438 4.03735C20.906 4.12846 20.8507 4.21124 20.781 4.28097L13.0605 12L20.781 19.719C20.8507 19.7887 20.906 19.8715 20.9438 19.9626C20.9815 20.0537 21.0009 20.1514 21.0009 20.25C21.0009 20.3486 20.9815 20.4462 20.9438 20.5373C20.906 20.6285 20.8507 20.7112 20.781 20.781C20.7112 20.8507 20.6285 20.906 20.5373 20.9438C20.4462 20.9815 20.3486 21.0009 20.25 21.0009C20.1514 21.0009 20.0537 20.9815 19.9626 20.9438C19.8715 20.906 19.7887 20.8507 19.719 20.781L12 13.0605L4.28097 20.781C4.21124 20.8507 4.12846 20.906 4.03735 20.9438C3.94624 20.9815 3.84859 21.0009 3.74997 21.0009C3.65135 21.0009 3.5537 20.9815 3.4626 20.9438C3.37149 20.906 3.2887 20.8507 3.21897 20.781C3.14924 20.7112 3.09392 20.6285 3.05619 20.5373C3.01845 20.4462 2.99902 20.3486 2.99902 20.25C2.99902 20.1514 3.01845 20.0537 3.05619 19.9626C3.09392 19.8715 3.14924 19.7887 3.21897 19.719L10.9395 12L3.21897 4.28097Z"
                          fill="#7F7F7F"/>
                </svg>
            </div>
            <style>
                .h2 {
                    font-size: 2.25em;
                    font-family: 'Merriweather';
                    text-transform: uppercase;
                    font-weight: 300;
                }
            </style>
            <div class="h2">Здесь можно оставить вашу заявку</div>
            <div class="popup__content">
                <div class="popup_content__inputs">
                    <div class="popup__input">
                        <p>Ваше имя</p>
                        <input class="item-form name" type="text" name="name" placeholder="Имя*" required>
                        <div class="form_error">
                            @error('name')
                            <div class="text-danger">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="popup__input">
                        <p>Ваш E-mail</p>
                        <input class="item-form" type="text" name="email" placeholder="E-mail*" required>
                        <div  class="form_error">
                            @error('email')
                            <div class="text-danger">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="popup__input country">
                        <p>Номер телефона</p>
                        <div class="poop">
                            <select name="country">
                                <option disabled>Выберите страну</option>
                                <option class="by">🇧🇾 +375</option>
                                <option class="ru">🇷🇺 +7</option>
                                <option class="kz">🇰🇿 +7</option>
                            </select>
                            <input class="item-form" type="text" name="phone" required>
                            <div  class="form_error">
                                @error('phone')
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="popup__input name-corp">
                        <p>Название организации</p>
                        <input id="name-corp" class="item-form" type="text" name="name_corp" placeholder="Название">
                        <div id="name-corp" class="form_error">
                            @error('name_corp')
                            <div class="text-danger">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="popup_content_inputs__comment popup__input">
                    <p>Интересует что-то конкретное?</p>
                    <textarea id="textarea-input" class="item-form textarea" name="textarea" type="text" rows="5"
                              placeholder="Ваш комментарий..."></textarea>
                    <div  class="form_error">
                        @error('textarea')
                        <div class="text-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="popup_content_inputs__file-button">
                    <div id="file-input" class="popup__input file">
                        <label for="file1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 12 24"
                                 fill="none">
                                <path d="M0.75 4.5C0.75 3.50544 1.14509 2.55161 1.84835 1.84835C2.55161 1.14509 3.50544 0.75 4.5 0.75C5.49456 0.75 6.44839 1.14509 7.15165 1.84835C7.85491 2.55161 8.25 3.50544 8.25 4.5V18C8.25 18.5967 8.01295 19.169 7.59099 19.591C7.16903 20.0129 6.59674 20.25 6 20.25C5.40326 20.25 4.83097 20.0129 4.40901 19.591C3.98705 19.169 3.75 18.5967 3.75 18V7.5C3.75 7.30109 3.82902 7.11032 3.96967 6.96967C4.11032 6.82902 4.30109 6.75 4.5 6.75C4.69891 6.75 4.88968 6.82902 5.03033 6.96967C5.17098 7.11032 5.25 7.30109 5.25 7.5V18C5.25 18.1989 5.32902 18.3897 5.46967 18.5303C5.61032 18.671 5.80109 18.75 6 18.75C6.19891 18.75 6.38968 18.671 6.53033 18.5303C6.67098 18.3897 6.75 18.1989 6.75 18V4.5C6.75 4.20453 6.6918 3.91194 6.57873 3.63896C6.46566 3.36598 6.29992 3.11794 6.09099 2.90901C5.88206 2.70008 5.63402 2.53434 5.36104 2.42127C5.08806 2.3082 4.79547 2.25 4.5 2.25C4.20453 2.25 3.91194 2.3082 3.63896 2.42127C3.36598 2.53434 3.11794 2.70008 2.90901 2.90901C2.70008 3.11794 2.53434 3.36598 2.42127 3.63896C2.3082 3.91194 2.25 4.20453 2.25 4.5V18C2.25 18.9946 2.64509 19.9484 3.34835 20.6516C4.05161 21.3549 5.00544 21.75 6 21.75C6.99456 21.75 7.94839 21.3549 8.65165 20.6516C9.35491 19.9484 9.75 18.9946 9.75 18V7.5C9.75 7.30109 9.82902 7.11032 9.96967 6.96967C10.1103 6.82902 10.3011 6.75 10.5 6.75C10.6989 6.75 10.8897 6.82902 11.0303 6.96967C11.171 7.11032 11.25 7.30109 11.25 7.5V18C11.25 19.3924 10.6969 20.7277 9.71231 21.7123C8.72774 22.6969 7.39239 23.25 6 23.25C4.60761 23.25 3.27226 22.6969 2.28769 21.7123C1.30312 20.7277 0.75 19.3924 0.75 18V4.5Z"
                                      fill="white"/>
                            </svg>
                        </label>
                        <input style="display: none" id="file1" class="item-form file" type="file" name="file"
                               placeholder="">
                        <p>Прикрепить файл, он должен быть не более 512 кб</p>
                        <div class="form_error">
                            @error('file')
                            <div class="text-danger">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                    <div style="position: absolute; margin:0; color: #c94a4a;" class="form_error">
                        @error('g-recaptcha-response')
                        <div class="text-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="submit__button">
                        <button class="form__form-button" type="button" onclick="onClick(event)">Заказать</button>
{{--                        <button type="submit">Оставить заявку</button>--}}
                        <p>Отправляя заявку, вы даете согласие на обработку своих персональных данных в соответствии
                            с Политикой конфиденциальности.</p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>




{{--<div class="popup popup_application">--}}
{{--    <div class="popup__body popup__body_application">--}}
{{--        <form class="popup__form" action="{{route('send_mail')}}" method="post" enctype="multipart/form-data" id="mail_form">--}}
{{--            @csrf--}}
{{--            <div class="popup__cross popup__cross_application">--}}
{{--            </div>--}}
{{--            <div class="h2">Здесь можно оставить вашу заявку</div>--}}
{{--            <div class="popup__content">--}}
{{--                <div class="popup_content__inputs">--}}
{{--                    <div class="popup__input">--}}
{{--                        <p>Ваше имя</p>--}}
{{--                        <input class="item-form name" type="text" name="name" placeholder="Имя*" required>--}}
{{--                        <div  class="form_error">--}}
{{--                            @error('name')--}}
{{--                            <div class="text-danger">--}}
{{--                                {{$message}}--}}
{{--                            </div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">--}}
{{--                    <div class="submit__button">--}}
{{--                        <button class="form__form-button" type="button" onclick="onClick(event)">Заказать</button>--}}
{{--                        --}}{{--                        <button type="submit">Оставить заявку</button>--}}
{{--                        <p>Отправляя заявку, вы даете согласие на обработку своих персональных данных в соответствии--}}
{{--                            с Политикой конфиденциальности.</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--</div>--}}
