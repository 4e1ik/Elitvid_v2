@extends('layouts.elitvid.elitvid')

@section('body-class', 'rd-page')

@section('content')
    <main>
        @include('includes.elitvid.popup_application')
        <section class="rd-pagehead">
            <div class="rd-wrap">
                <h1>Наши новости</h1>
            </div>
        </section>
        <div class="rd-wrap">
            <section class="rd-section">
                <div class="rd-grid">
                    @foreach($blogs as $blog)
                        @php
                            $mainImage = $blog->images()->where('main_image', true)->first();
                            $imagePath = $mainImage ? $mainImage->image : ($blog->attributes['main_image'] ?? null);
                            $imageUrl = $imagePath ? asset('storage/'.str_replace('public/','',$imagePath)) : null;
                        @endphp
                        <x-elitvid.blog-card
                            :href="route('show_blog_post', ['slug' => $blog->slug])"
                            :image="$imageUrl"
                            :title="$blog->title"
                            :description="$blog->description" />
                    @endforeach
                </div>
            </section>
            @if($category)
                <section class="rd-section">{!! $category !!}</section>
            @endif
        </div>
    </main>
@endsection
