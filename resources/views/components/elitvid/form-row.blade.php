@props(['image', 'title', 'href', 'alt' => '', 'side' => false])

{{-- side: текст и кнопка справа, линия посередине (кадр «скамьи»); иначе линия под текстом, кнопка справа (кадр «кашпо») --}}
<div @class(['rd-form-row', 'rd-form-row--side' => $side])>
    <img class="rd-form-row__image" src="{{ $image }}" alt="{{ $alt }}" loading="lazy">
    @if ($side)
        <span class="rd-form-row__line" aria-hidden="true"></span>
    @endif
    <div class="rd-form-row__text">
        <h3>{{ $title }}</h3>
        <p>{{ $slot }}</p>
    </div>
    <a class="rd-form-row__link" href="{{ $href }}">Смотреть коллекцию</a>
</div>
