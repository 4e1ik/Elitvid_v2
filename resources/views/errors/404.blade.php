@extends('layouts.elitvid.elitvid')
@section('404')
<meta name="robots" content="noindex, nofollow">
@parent
@endsection

@section('content')
    <section class="stub">
        <div class="stub__text error_text">
            <h1>404</h1>
            <p>Страница не найдена 😕</p>
            <a href="{{ route('home') }}">Вернуться на главную</a>
        </div>
    </section>
@endsection
