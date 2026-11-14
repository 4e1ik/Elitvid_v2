@extends('layouts.elitvid.elitvid')

@section('body-class', 'rd-page')

@section('content')
    <main>
        @include('includes.elitvid.popup_application')
        <section class="rd-pagehead">
            <div class="rd-wrap">
                <h1>Наши направления</h1>
                <p>Доверьте нам свои идеи, и мы поможем Вам воплотить их в жизнь. Свяжитесь с нами сегодня и начните реализацию своего проекта!</p>
                <button class="rd-btn rd-btn--accent open_popup_application" type="button">Оставить заявку</button>
            </div>
        </section>
        <div class="rd-wrap">
            <section class="rd-section">
                @include('includes.elitvid.redesign-directions')
            </section>
            @if($pageContent && $pageContent->category_description)
                <section class="rd-section">
                    <div class="text">{!! $pageContent->category_description !!}</div>
                </section>
            @endif
        </div>
    </main>
@endsection
