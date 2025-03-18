@extends('layouts.elitvid.elitvid')
@section('content')
    <section class="stub">
        <div class="stub__text">
            <h3>Спасибо за вашу заявку!</h3>
            <p>Вы будете автоматически перенаправлены обратно через 3 секунды...</p>
            <a href="{{ route('home') }}">Вернуться на главную</a>
        </div>
    </section>
    <script>
        const referrer = new URLSearchParams(window.location.search).get('referrer') || '/';
        setTimeout(() => {
            window.location.href = referrer;
        }, 3000);
    </script>
@endsection
