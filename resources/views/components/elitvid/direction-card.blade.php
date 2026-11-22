@props(['image', 'label', 'alt' => '', 'href' => null])

@if ($href)
    <a {{ $attributes->class(['rd-card']) }} href="{{ $href }}">
@else
    <div {{ $attributes->class(['rd-card']) }}>
@endif
    <span class="rd-card__photo">
        <img src="{{ $image }}" alt="{{ $alt !== '' ? $alt : $label }}" width="367" height="280" loading="lazy">
    </span>
    <span class="rd-card__label">{{ $label }}</span>
@if ($href)
    </a>
@else
    </div>
@endif
