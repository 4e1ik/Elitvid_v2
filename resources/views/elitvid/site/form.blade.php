@extends('layouts.elitvid.elitvid')

@section('content')
{{--    @include('includes.elitvid.form')--}}

<section class="form__main section-item">
    <div class="container">
        <div class="about__main-header section-header">
            <h2>Заказать звонок</h2>
        </div>
    </div>
</section>
<section class="section-item">
    <div class="container">
        <div class="second_section-header">
            <h3>Заполните форму</h3>
        </div>
        <div class="form__main-items">
            <div class="form__form" id="content">
                <div class="form__form-content">
                    <div class="form__form-form">
                        <form action="{{route('send_mail')}}" method="post" enctype="multipart/form-data" id="mail_form">
                            @csrf
                            <div class="item__form">
                                <div class="text__form">
                                    <p>Ваше имя</p>
                                </div>
                                <input class="item-form" type="text" name="name" placeholder="  Ваше имя" required>
                                @error('name')
                                <div class="text-danger">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>

                            <div class="item__form">
                                <div class="text__form">
                                    <p>Ваша почта</p>
                                </div>
                                <input class="item-form" type="text" name="email" placeholder="  Ваша почта" required>
                                @error('email')
                                <div class="text-danger">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>

                            <div class="item__form">
                                <div class="text__form">
                                    <p>Название организации</p>
                                </div>
                                <input class="item-form" type="text" name="name_corp" placeholder="  Название организации">
                                @error('name_corp')
                                <div class="text-danger">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>

                            <div class="item__form">
                                <div class="text__form">
                                    <p>Ваш номер телефона</p>
                                </div>
                                <input class="item-form" type="text" name="phone" placeholder="  Номер телефона" required>
                                @error('phone')
                                <div class="text-danger">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>

                            <div class="item__form">
                                <div class="text__form">
                                    <p>Прикрепить файл</p>
                                </div>
                                <p style="text-align: center">Файл должен быть не более 512 кб</p>
                                <input style="cursor: pointer" class="item-form file" type="file" name="file" placeholder="">
                                <label for="file">

                                </label>
                                @error('file')
                                <div class="text-danger">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>

                            <div class="item__form">
                                <div class="text__form">
                                    <p>Ваш комментарий</p>
                                </div>
                                <textarea class="item-form textarea" name="textarea" type="text" id="" rows="5" placeholder="  Комментарий"></textarea>
                                @error('textarea')
                                <div class="text-danger">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>


                            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
{{--                            @error('g-recaptcha-response')--}}
{{--                            <div class="text-danger">--}}
{{--                                <p>{{$message}}</p>--}}
{{--                            </div>--}}
{{--                            @enderror--}}
                            <button class="form__form-button" type="button" onclick="onClick(event)">Заказать</button>
{{--                            <button class="form__form-button" type="submit">Заказать</button>--}}
                            <div class="text__form text" style="margin-top: 1em; text-align: center">
                                <p>Нажимая кнопку Заказать вы даете согласие на обработку своих персональных данных</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
