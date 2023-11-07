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
                            <input class="item-form" type="text" name="name" placeholder="  Ваше имя" required>
                            <input class="item-form" type="text" name="email" placeholder="  Ваша почта" required>
                            <input class="item-form" type="text" name="name_corp" placeholder="  Название организации">
                            <input class="item-form" type="text" name="phone" placeholder="  Номер телефона" required>
                            <input class="item-form file" type="file" name="file" placeholder="">
{{--                            <br>--}}
                            Файл должен быть не более 512 кб
                            <textarea name="item-form textarea" type="text" id="" rows="5" placeholder="  Комментарий"></textarea>
                            <button data-sitekey="{{config('services.recaptcha.site_key')}}" data-callback='onSubmit' data-action='mail_form' type="submit" class="form__form-button g-recaptcha">Заказать</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
