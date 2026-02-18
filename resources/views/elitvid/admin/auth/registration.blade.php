@extends('layouts.elitvid.admin.login_and_registration')

@section('login_and_registration')

    <div class="container">

        <form action="{{ route('save') }}" method="POST" class="form-signin">
            <div class="panel periodic-login">
                @csrf
                <div class="panel-body text-center">
                    <h1 class="atomic-symbol h3">ELITVID</h1>
                    <p class="element-name">Регистрация в админ-панели</p>

                    <i class="icons icon-arrow-down"></i>
                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                        <input type="text" name="username" class="form-text" value="{{ old('username') }}" required>
                        <span class="bar"></span>
                        <label>Имя пользователя</label>
                    </div>
                    @error('username')
                    <div class="alert alert-danger text-left" role="alert">{{ $message }}</div>
                    @enderror
                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                        <input type="email" name="email" class="form-text" value="{{ old('email') }}" required>
                        <span class="bar"></span>
                        <label>Email</label>
                    </div>
                    @error('email')
                    <div class="alert alert-danger text-left" role="alert">{{ $message }}</div>
                    @enderror
                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                        <input type="password" name="password" class="form-text" required>
                        <span class="bar"></span>
                        <label>Пароль</label>
                    </div>
                    @error('password')
                    <div class="alert alert-danger text-left" role="alert">{{ $message }}</div>
                    @enderror
                    <div class="alert alert-danger small text-left" role="alert">Пароль: минимум 10 символов, буквы разного регистра и цифры.</div>
                    <label class="pull-left">
                        <div class="icheckbox_flat-aero" style="position: relative;">
                            <input type="checkbox" class="icheck pull-left" name="terms" value="1" style="position: absolute; opacity: 0;">
                            <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                        </div>
                        Согласен с условиями и политикой конфиденциальности
                    </label>
                    <input type="submit" class="btn col-md-12" value="Зарегистрироваться">
                </div>
                <div class="text-center" style="padding:5px;">
                    <a href="{{ route('login') }}">Уже есть аккаунт? Войти</a>
                </div>
            </div>
        </form>

    </div>

@endsection
