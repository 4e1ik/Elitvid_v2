@extends('layouts.elitvid.elitvid')
@section('content')
    <section class="stub">
        <div class="stub__text">
            <h1>Спасибо за вашу заявку!</h1>
            <p>Вы будете автоматически перенаправлены обратно через 2 секунды...</p>
            <a href="{{ route('home') }}">Вернуться на главную</a>
        </div>
    </section>
    <script>
        const referrer = new URLSearchParams(window.location.search).get('referrer') || '/';
        setTimeout(() => {
            window.location.href = referrer;
        }, 2000);
    </script>
@endsection
