@extends('layouts.elitvid.elitvid')

@section('content')

    <main>
        @include('includes.elitvid.popup_call')
        @include('includes.elitvid.popup_application')
        {{-- @include('includes.elitvid.breadcrumbs') --}}
        @foreach($products as $product)
        <section class="breadcrumbs">
            <div class="breadcrumbs__links">
                <a href="{{route('home')}}">Главная</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M4.64592 2.14689C4.69236 2.10033 4.74754 2.06339 4.80828 2.03818C4.86903 2.01297 4.93415 2 4.99992 2C5.06568 2 5.13081 2.01297 5.19155 2.03818C5.2523 2.06339 5.30747 2.10033 5.35392 2.14689L11.3539 8.14689C11.4005 8.19334 11.4374 8.24852 11.4626 8.30926C11.4878 8.37001 11.5008 8.43513 11.5008 8.50089C11.5008 8.56666 11.4878 8.63178 11.4626 8.69253C11.4374 8.75327 11.4005 8.80845 11.3539 8.85489L5.35392 14.8549C5.26003 14.9488 5.13269 15.0015 4.99992 15.0015C4.86714 15.0015 4.7398 14.9488 4.64592 14.8549C4.55203 14.761 4.49929 14.6337 4.49929 14.5009C4.49929 14.3681 4.55203 14.2408 4.64592 14.1469L10.2929 8.50089L4.64592 2.85489C4.59935 2.80845 4.56241 2.75327 4.5372 2.69253C4.512 2.63178 4.49902 2.56666 4.49902 2.50089C4.49902 2.43513 4.512 2.37001 4.5372 2.30926C4.56241 2.24852 4.59935 2.19334 4.64592 2.14689Z"
                          fill="white"/>
                </svg>
                <a href="{{route('directions')}}">Наши направления</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M4.64592 2.14689C4.69236 2.10033 4.74754 2.06339 4.80828 2.03818C4.86903 2.01297 4.93415 2 4.99992 2C5.06568 2 5.13081 2.01297 5.19155 2.03818C5.2523 2.06339 5.30747 2.10033 5.35392 2.14689L11.3539 8.14689C11.4005 8.19334 11.4374 8.24852 11.4626 8.30926C11.4878 8.37001 11.5008 8.43513 11.5008 8.50089C11.5008 8.56666 11.4878 8.63178 11.4626 8.69253C11.4374 8.75327 11.4005 8.80845 11.3539 8.85489L5.35392 14.8549C5.26003 14.9488 5.13269 15.0015 4.99992 15.0015C4.86714 15.0015 4.7398 14.9488 4.64592 14.8549C4.55203 14.761 4.49929 14.6337 4.49929 14.5009C4.49929 14.3681 4.55203 14.2408 4.64592 14.1469L10.2929 8.50089L4.64592 2.85489C4.59935 2.80845 4.56241 2.75327 4.5372 2.69253C4.512 2.63178 4.49902 2.56666 4.49902 2.50089C4.49902 2.43513 4.512 2.37001 4.5372 2.30926C4.56241 2.24852 4.59935 2.19334 4.64592 2.14689Z"
                          fill="white"/>
                </svg>
                <a href="{{route('pots')}}">Кашпо</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M4.64592 2.14689C4.69236 2.10033 4.74754 2.06339 4.80828 2.03818C4.86903 2.01297 4.93415 2 4.99992 2C5.06568 2 5.13081 2.01297 5.19155 2.03818C5.2523 2.06339 5.30747 2.10033 5.35392 2.14689L11.3539 8.14689C11.4005 8.19334 11.4374 8.24852 11.4626 8.30926C11.4878 8.37001 11.5008 8.43513 11.5008 8.50089C11.5008 8.56666 11.4878 8.63178 11.4626 8.69253C11.4374 8.75327 11.4005 8.80845 11.3539 8.85489L5.35392 14.8549C5.26003 14.9488 5.13269 15.0015 4.99992 15.0015C4.86714 15.0015 4.7398 14.9488 4.64592 14.8549C4.55203 14.761 4.49929 14.6337 4.49929 14.5009C4.49929 14.3681 4.55203 14.2408 4.64592 14.1469L10.2929 8.50089L4.64592 2.85489C4.59935 2.80845 4.56241 2.75327 4.5372 2.69253C4.512 2.63178 4.49902 2.56666 4.49902 2.50089C4.49902 2.43513 4.512 2.37001 4.5372 2.30926C4.56241 2.24852 4.59935 2.19334 4.64592 2.14689Z"
                          fill="white"/>
                </svg>
                <a href="{{route($product->collection == 'Square' ?
                    'square_pots':($product->collection == 'Round' ?
                        'round_pots': ($product->collection == 'Rectangular' ?
                            'rectangular_pots' : '')))}}">
                                    {{ $product->collection == 'Square' ?
                                    'Квадратные кашпо':($product->collection == 'Round' ?
                                        'Круглые кашпо': ($product->collection == 'Rectangular' ?
                                            'Прямоугольные кашпо' : '')) }}
                                    </a>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M4.64592 2.14689C4.69236 2.10033 4.74754 2.06339 4.80828 2.03818C4.86903 2.01297 4.93415 2 4.99992 2C5.06568 2 5.13081 2.01297 5.19155 2.03818C5.2523 2.06339 5.30747 2.10033 5.35392 2.14689L11.3539 8.14689C11.4005 8.19334 11.4374 8.24852 11.4626 8.30926C11.4878 8.37001 11.5008 8.43513 11.5008 8.50089C11.5008 8.56666 11.4878 8.63178 11.4626 8.69253C11.4374 8.75327 11.4005 8.80845 11.3539 8.85489L5.35392 14.8549C5.26003 14.9488 5.13269 15.0015 4.99992 15.0015C4.86714 15.0015 4.7398 14.9488 4.64592 14.8549C4.55203 14.761 4.49929 14.6337 4.49929 14.5009C4.49929 14.3681 4.55203 14.2408 4.64592 14.1469L10.2929 8.50089L4.64592 2.85489C4.59935 2.80845 4.56241 2.75327 4.5372 2.69253C4.512 2.63178 4.49902 2.56666 4.49902 2.50089C4.49902 2.43513 4.512 2.37001 4.5372 2.30926C4.56241 2.24852 4.59935 2.19334 4.64592 2.14689Z"
                          fill="white"/>
                </svg>
                <p style="font-size: 12px">{{ $product->name}}</p>
            </div>
        </section>
        <section class="product">
            
                <h1 style="font-size: 2.25em; font-family:'Merriweather'; text-transform: uppercase; font-weight: 300;">{{$product->name}}</h1>
                <div class="product__content">
                    <div class="product_content__images">
                        <div class="content_images__textures">
                            <h4>Фактуры:</h4>
                            <p class="images_textures__text">Выберите фактуру и цвет для визуализации кашпо</p>
                            <div class="images_textures__images">
                                <div class="image_texture">
                                    <img data-texture="porous" src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/pots/textures/texture-porous.png')}}" alt="">
                                    <p>Пористая</p>
                                    <img data-texture="porous" class="texture_popup__image" src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/pots/textures/texture-porous.png')}}"
                                         alt="">
                                    <p class="texture_popup__text">Пористая</p>
                                </div>
                                <div class="image_texture">
                                    <img data-texture="smooth" src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/pots/textures/texture-smooth.png')}}" alt="">
                                    <p>Гладкая</p>
                                    <img data-texture="smooth" class="texture_popup__image" src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/pots/textures/texture-smooth.png')}}"
                                         alt="">
                                    <p class="texture_popup__text">Гладкая</p>
                                </div>
                                <div class="image_texture">
                                    <img data-texture="marble" src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/pots/textures/texture-marble.png')}}" alt="">
                                    <p>Мрамор</p>
                                    <img data-texture="marble" class="texture_popup__image" src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/pots/textures/texture-marble.png')}}"
                                         alt="">
                                    <p class="texture_popup__text">Мрамор</p>
                                </div>
                            </div>
                        </div>
                        <div id="product-images" class="content_images__main-image">
                            <img id="first_image" src="{{asset('storage/'.str_replace('public/','',$product->pot_images[0]->image))}}" alt="{{$product->pot_images[0]->description_image}}">
                            @foreach($product->pot_images as $image)
                                <img id="image" data-texture="{{ $image->texture }}" data-color="{{ $image->color }}" class="main-image__image" src="{{asset('storage/'.str_replace('public/','',$image->image))}}" alt="{{$image->description_image}}">
                            @endforeach
                        </div>
                        <div class="content_images__colors">
                            <h4>Цвета</h4>
                            <div class="images_colors__images">
                                <div data-color="grey" data-title="Серый бетон" class="image_color">
                                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/pots/colors/grey_concrete_color.png')}}" alt="">
                                </div>
                                <div data-color="graphite" data-title="Графит" class="image_color">
                                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/pots/colors/graphite_color.png')}}" alt="">
                                </div>
                                <div data-color="black" data-title="Черный" class="image_color">
                                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/pots/colors/black_color.png')}}" alt="">
                                </div>
                                <div data-color="white" data-title="Белый" class="image_color">
                                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/pots/colors/white_color.png')}}" alt="">
                                </div>
                                <div data-color="ivory" data-title="Слоновая кость" class="image_color">
                                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/pots/colors/ivory_color.png')}}" alt="">
                                </div>
                                <div data-color="sand" data-title="Песочный" class="image_color">
                                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/pots/colors/sand_color.png')}}" alt="">
                                </div>
                                <div data-color="orange" data-title="Оранжевый" class="image_color">
                                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/pots/colors/orange_color.png')}}" alt="">
                                </div>
                                <div data-color="olive" data-title="Оливка" class="image_color">
                                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/pots/colors/olive_color.png')}}" alt="">
                                </div>
                                <div data-color="malachite" data-title="Малахит" class="image_color">
                                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/pots/colors/malachite_color.png')}}" alt="">
                                </div>
                                <div data-color="white_blue" data-title="Голубой" class="image_color">
                                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/pots/colors/white-blue_color.png')}}" alt="">
                                </div>
                                <div data-color="blue" data-title="Синий" class="image_color">
                                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/pots/colors/blue_color.png')}}" alt="">
                                </div>
                                <div data-color="bronze" data-title="Бронза" class="image_color">
                                    <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/pots/colors/bronze_color.png')}}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product_content__table">
                        <div class="content_table__title">
                            <h4>Материал:</h4>
                            <p>{{$product->material}}</p>
                        </div>
                        <div class="content_table__table">
                            @foreach($rows  as  $row)
                                @if(!empty(explode('|',$row)[0]) || !empty(explode('|',$row)[1]) || !empty(explode('|',$row)[2]))
                                    <div class="table__row">
                                        @if(!empty(explode('|',$row)[0]))
                                            <div class="table_row__size">
                                                <p>Размер</p>
                                                <p>{{explode('|',$row)[0]}}</p>
                                            </div>
                                        @endif
                                        @if(!empty(explode('|',$row)[0]) && !empty(explode('|',$row)[1]))
                                            <div class="table_row__vertical-line"></div>
                                        @endif
                                        @if(!empty(explode('|',$row)[1]))
                                            <div class="table_row__weight">
                                                <p>Вес</p>
                                                <p class="thumbnail">{{explode('|',$row)[1]}}</p>
                                            </div>
                                        @endif
                                        @if(!empty(explode('|',$row)[2]))
                                            <div class="table_row__price">
                                                <p>Цена</p>
                                                <p class="thumbnail price">от {{explode('|',$row)[2]}}</p>
                                                <p class="thumbnail mobile-price">
                                                    от {{explode('|',$row)[2]}}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="content_table__description">
                            <p>*Изготовим по Вашему проекту, эскизу</p>
                        </div>
                    </div>
                </div>
                <div class="submit-application">
                    <button class="submit-application--button open_popup_application">
                        Оставить заявку
                    </button>
                </div>
                <div class="submit-application submit-application--mobile">
                    <button class="submit-application--button open_popup_application1 submit-application-button--mobile">
                        Оставить заявку
                    </button>
                </div>
            
        </section>
        @endforeach
        <section class="offered_products">
            <h2>Другие формы</h2>
            <div class="offered_product_slider">
                <div style="height: 25em" class="offered_product__slider swiper">
                    <!-- Additional required wrapper -->
{{--                    @dd($rand_products)--}}
                    <div class="offered_product-swiper-wrapper__slider swiper-wrapper">
                        <!-- Slides -->
                        @foreach($rand_products->where('collection', $product->collection) as $rand_product)
                            <div class="swiper-slide">
                                <div class="direction">
                                    <img src="{{asset('storage/'.str_replace('public/','',$rand_product->pot_images[0]->image))}}"
                                         alt="Фотография направления кашпо">
                                    <a href="{{route('show_pot_product', ['collection' => ($product->collection == 'Square' ?
                                                                                'square_pots':($product->collection == 'Round' ?
                                                                                    'round_pots': ($product->collection == 'Rectangular' ?
                                                                                        'rectangular_pots' : ''))), 'id' => $rand_product->id])}}">
                                        <button>{{$rand_product->name}}</button>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="swiper-button-prev arrow-left arrow">
                        <svg width="12" height="18" viewBox="0 0 12 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path id="Line 1" d="M9.54419 1.5L2.45559 9L9.54419 16.5" stroke="white" stroke-width="2.99575"
                                  stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="swiper-button-next arrow-right arrow">
                        <svg width="12" height="18" viewBox="0 0 12 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path id="Line 1" d="M2.45581 1.5L9.54441 9L2.45581 16.5" stroke="white" stroke-width="2.99575"
                                  stroke-linecap="round"/>
                        </svg>
                    </div>

                </div>
            </div>
        </section>
    </main>
@endsection
