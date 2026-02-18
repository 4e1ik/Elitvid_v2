@extends('layouts.elitvid.admin.login_and_registration')

@section('login_and_registration')

    <div class="container">

        <form class="form-signin" action="{{ route('login') }}" method="POST">
            <div class="panel periodic-login">
                @csrf
                <div class="panel-body text-center">
                    <h1 class="atomic-symbol h3">ELITVID</h1>
                    <p class="element-name">Панель администратора</p>

                    <i class="icons icon-arrow-down"></i>
                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                        <input type="email" name="email" class="form-text" value="{{ old('email') }}" required autofocus>
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
                    <label class="pull-left">
                        <div class="icheckbox_flat-aero" style="position: relative;">
                            <input type="checkbox" class="icheck pull-left" name="remember" value="1" style="position: absolute; opacity: 0;">
                            <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                        </div>
                        Запомнить меня
                    </label>
                    <input type="submit" class="btn col-md-12" value="Войти">
                </div>
                <div class="text-center" style="padding:5px;">
                    <a href="{{ route('registration') }}">Регистрация</a>
                </div>
            </div>
        </form>

    </div>

@endsection
