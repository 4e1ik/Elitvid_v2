{{-- Крошки нового вида: без «Главной», как в кадрах «ребрендинг» --}}
@php
    $crumbs = \Tabuna\Breadcrumbs\Breadcrumbs::has() ? \Tabuna\Breadcrumbs\Breadcrumbs::current()->slice(1) : collect();
@endphp
@if ($crumbs->isNotEmpty())
    <nav class="rd-crumbs" aria-label="Хлебные крошки">
        @foreach ($crumbs as $crumb)
            @if ($loop->last)
                <span aria-current="page">{{ $crumb->title() }}</span>
            @else
                <a href="{{ $crumb->url() }}">{{ $crumb->title() }}</a>
            @endif
        @endforeach
    </nav>
@endif
