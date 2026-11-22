@props(['title', 'images'])

<section class="rd-section works">
    <h2>{{ $title }}</h2>
    <div class="works-examples">
        <div class="main__slider swiper">
            <div class="main-swiper-wrapper__slider swiper-wrapper">
                @foreach ($images as $image)
                    <div class="swiper-slide"><img src="{{ asset('storage/'.str_replace('public/', '', $image->image)) }}" alt="{{ $image->description_image ?? '' }}" loading="lazy"></div>
                @endforeach
            </div>
            <div class="swiper-button-prev arrow-left arrow">
                <svg width="12" height="18" viewBox="0 0 12 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.54419 1.5L2.45559 9L9.54419 16.5" stroke="white" stroke-width="2.99575" stroke-linecap="round"/></svg>
            </div>
            <div class="swiper-button-next arrow-right arrow">
                <svg width="12" height="18" viewBox="0 0 12 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.45581 1.5L9.54441 9L2.45581 16.5" stroke="white" stroke-width="2.99575" stroke-linecap="round"/></svg>
            </div>
        </div>
        <div class="thumbs__slider swiper">
            <div class="main-swiper-wrapper__slider swiper-wrapper">
                @foreach ($images as $image)
                    <div class="swiper-slide"><img src="{{ asset('storage/'.str_replace('public/', '', $image->image)) }}" alt="{{ $image->description_image ?? '' }}" loading="lazy"></div>
                @endforeach
            </div>
        </div>
    </div>
</section>
