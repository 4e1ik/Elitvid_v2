@extends('layouts.elitvid.elitvid')

@section('content')
<main>
    @include('includes.elitvid.popup_call')
    @include('includes.elitvid.popup_application')
    @include('includes.elitvid.breadcrumbs')
    <section class="main">
        <div class="description">
            <div class="description-text">
                <h1>Прямоугольные <br>кашпо</h1>
                <p>Композиция в таких формах смотрится очень стильно. Есть возможность добавить подсветку растений.</p>
            </div>
            <div class="submit-application">
                <button class="submit-application--button open_popup_application">
                    Оставить заявку
                </button>
            </div>
            @include('includes.elitvid.catalog_price_pots')
        </div>
        <div class="stages">
            <div class="image">
                <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/rectangular_pots.png')}}" alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/rectangular_pots.png']}}"
                     class="main-page-up">
            </div>
            <div class="submit-application submit-application--mobile">
                <button class="submit-application--button open_popup_application1 submit-application-button--mobile">
                    Оставить заявку
                </button>
            </div>
            @include('includes.elitvid.mobile_catalog_price_pots')
        </div>
    </section>
    <section class="not_main_page produce">
        <h2>Выберите форму</h2>
        <div class="not_main_page directions">
            @foreach($rectangular_pots as $product)
                <div class="direction">
                    <img src="{{asset('storage/'.str_replace('public/','',$product->pot_images[0]->image))}}" alt="{{$product->pot_images[0]->description_image}}">
                    <a href="{{route('show_pot_product', ['collection' => 'rectangular_pots', 'id' => $product->id])}}">
                        <button>{{$product->name}}</button>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
    @if($category)
        <section class="description">
            <div class="text">
                {!! $category !!}
            </div>
        </section>
    @endif
</main>
@endsection
