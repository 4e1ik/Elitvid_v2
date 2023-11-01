@extends('layouts.elitvid.elitvid')

@section('content')
    <section class="pots__main section-item">
        <div class="container">
            <div class="pots__main-header section-header">
                <h2>Кашпо и вазоны</h2>
            </div>
            <div class="catalog__main-items">
                <div class="catalog__item-card">
                    <a href="{{route('square_pots')}}">
                        <img src="" alt="">
                        <div class="catalog__card-header">
                            <h3>Квадратные</h3>
                        </div>
                    </a>
                </div>
                <div class="catalog__item-card">
                    <a href="{{route('round_pots')}}">
                        <img src="" alt="">
                        <div class="catalog__card-header">
                            <h3>Круглые</h3>
                        </div>
                    </a>
                </div>
                <div class="catalog__item-card">
                    <a href="{{route('rectangular_pots')}}">
                        <img src="" alt="">
                        <div class="catalog__card-header">
                            <h3>Прямоугольные</h3>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="texture__main section-item">
        <div class="container">
            <div class="texture__main-header section-header">
                <h2>Фактура</h2>
            </div>
            <div class="texture__name-header second_section-header">
                <h3>Натуральный камень</h3>
            </div>
            <div class="texture__main-items">
                @foreach($natural_stone as $stone)
                <div class="texture__item-card">
                    @foreach($stone->images as $image)
                            <img src="{{ asset('storage/'.$image->image) }}" alt="{{$image->description_image}}">
                    @endforeach
                    <div class="texture__card-header">
                        <h3><a href="">{{$stone->texture_name}}</a></h3>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="texture__name-header second_section-header">
                <h3>Лунный камень</h3>
            </div>
            <div class="texture__main-items">
                @foreach($moon_stone as $stone)
                    <div class="texture__item-card">
                        @foreach($stone->images as $image)
                            <img src="{{ asset('storage/'.$image->image) }}" alt="{{$image->description_image}}">
                        @endforeach
                        <div class="texture__card-header">
                            <h3><a href="">{{$stone->texture_name}}</a></h3>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="texture__name-header second_section-header">
                <h3>Полированный камень</h3>
            </div>
            <div class="texture__main-items">
                @foreach($mirror_stone as $stone)
                    <div class="texture__item-card">
                        @foreach($stone->images as $image)
                            <img src="{{ asset('storage/'.$image->image) }}" alt="{{$image->description_image}}">
                        @endforeach
                        <div class="texture__card-header">
                            <h3><a href="">{{$stone->texture_name}}</a></h3>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="gallery__main section-item">
        <div class="container">
            <div class="gallery__main-header section-header">
                <h2>Примеры работ</h2>
            </div>
            <div class="gallery__main-items">
                @foreach($pots_gallery as $gallery_images)
                    @foreach($gallery_images->images as $image)
                <div class="gallery__item-card">
                    <a href="{{ asset('storage/'.$image->image) }}" data-lightbox="pots-images">
                        <img src="{{ asset('storage/'.$image->image) }}" alt="">
                    </a>
                </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </section>
    @include('includes.elitvid.form')
@endsection
