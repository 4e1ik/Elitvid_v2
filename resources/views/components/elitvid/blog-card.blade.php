@props(['href', 'image' => null, 'title', 'description' => ''])

<article class="rd-card rd-card--blog">
    <a href="{{ $href }}">
        <span class="rd-card__photo">
            @if($image)
                <img src="{{ $image }}" alt="" width="367" height="210" loading="lazy">
            @endif
        </span>
    </a>
    <h3>{{ $title }}</h3>
    @if($description)
        <p>{{ $description }}</p>
    @endif
    <a class="rd-card__label" href="{{ $href }}">Читать далее</a>
</article>
