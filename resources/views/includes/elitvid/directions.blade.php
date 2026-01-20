<div class="directions">
    <style>
        h3 {
            font-size: 1em;
            font-family: "Merriweather";
            text-transform: uppercase;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: normal;
        }

        h3 button {
            font-family: "Montserrat-Medium";
            color: #FFFFFF;
            margin-top: 1.5em;
            width: 22.9375em;
            height: 3.875em;
            padding: 0.625em 0;
            border-radius: 8px;
            border: 1px solid #979797;
            background: #22242A;
            cursor: pointer;
            transition: 0.2s;
            text-transform: uppercase;
        }
    </style>
    <div class="direction">
        <div class="direction__image">
            <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/pots.webp')}} "
                 alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/pots.webp'] ?? ''}}"
                 loading="lazy">
        </div>
        <h3><a href="{{route('pots')}}">
                <button>Кашпо</button>
            </a></h3>
    </div>
    <style>
        .slogan__direction .slogan__direction-text .h4 {
            font-size: 1.125em;
            font-family: 'Montserrat-SemiBold';
        }

        h3 > a {
            width: 100%;
        }
    </style>
    <div class="slogan__direction">
        <div class="slogan__direction-text">
            <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/img.webp')}}" alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/main_page/img.webp'] ?? ''}}"
                 loading="lazy">
            <div class="h4">Мы воплотим в реальность любую вашу идею!</div>
            <p>Работаем по индивидуальным размерам, эскизам и чертежам. Гарантируем качественное и
                профессиональное
                выполнение проекта. Наш опыт и знания позволяют реализовывать сложные и оригинальные задачи.
                Мы
                осуществляем доставку в разные страны и стремимся к долгосрочному сотрудничеству. Доверьте
                нам
                свои
                идеи, и мы поможем воплотить их в жизнь.</p>
        </div>

    </div>
    <div class="direction">
        <div class="direction__image">
            <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/benches.webp')}}"
                 alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/benches.webp'] ?? ''}}"
                 loading="lazy">
        </div>
        <h3>
            <a href="{{route('benches')}}">
                <button>Скамьи</button>
            </a>
        </h3>
    </div>
    <div class="direction">
        <div class="direction__image">
            <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/bollards.webp')}}"
                 alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/bollards.webp'] ?? ''}}"
                 loading="lazy">
        </div>
        <h3>
            <a href="{{route('bollards_and_fencing')}}">
                <button>Болларды и ограждения</button>
            </a>
        </h3>
    </div>
    @foreach($static_pages as $static_page)
        <div class="direction">
            <div class="direction__image">
                <img src="{{asset('/storage/'.str_replace('public/','',$static_page->images()->where('main_image', true)->first()->image)) ?? ''}}"
                     alt="{{$static_page->images()->where('main_image', true)->first()->image->description_image ?? ''}}"
                loading="lazy">
            </div>
            <h3>
                <a href="{{route('static_page', ['slug' => $static_page->slug])}}">
                    <button>{{$static_page->menu_name}}</button>
                </a>
            </h3>
        </div>
    @endforeach


{{--    <div class="direction">--}}
{{--        <div class="direction__image">--}}
{{--            <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/rotundas.webp')}}"--}}
{{--                 alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/rotundas.webp'] ?? ''}}">--}}
{{--        </div>--}}
{{--        <h3>--}}
{{--            <a href="{{route('rotundas_and_colonnades')}}">--}}
{{--                <button>Ротонды и колонны</button>--}}
{{--            </a>--}}
{{--        </h3>--}}
{{--    </div>--}}
{{--    <div class="direction">--}}
{{--        <div class="direction__image">--}}
{{--            <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/parklets.webp')}}"--}}
{{--                 alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/parklets.webp'] ?? ''}}">--}}
{{--        </div>--}}
{{--        <h3>--}}
{{--            <a href="{{route('parklets_and_canopies')}}">--}}
{{--                <button>Парклеты, навесы</button>--}}
{{--            </a>--}}
{{--        </h3>--}}
{{--    </div>--}}
{{--    --}}
{{--    <div class="direction">--}}
{{--        <div class="direction__image">--}}
{{--            <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/pillars.webp')}}"--}}
{{--                 alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/pillars.webp'] ?? ''}}">--}}
{{--        </div>--}}
{{--        <h3>--}}
{{--            <a href="{{route('pillars_and_covers')}}">--}}
{{--                <button>Столбы и накрывки</button>--}}
{{--            </a>--}}
{{--        </h3>--}}
{{--    </div>--}}
{{--    <div class="direction">--}}
{{--        <div class="direction__image">--}}
{{--            <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/facade_stucco.webp')}}"--}}
{{--                 alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/facade_stucco.webp'] ?? ''}}">--}}
{{--        </div>--}}
{{--        <h3>--}}
{{--            <a href="{{route('facade_stucco_molding_and_panels')}}">--}}
{{--                <button>Фасадная лепнина и панели</button>--}}
{{--            </a>--}}
{{--        </h3>--}}
{{--    </div>--}}
{{--    <div class="direction">--}}
{{--        <div class="direction__image">--}}
{{--            <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/1maf.webp')}}"--}}
{{--                 alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/1maf.webp'] ?? ''}}">--}}
{{--        </div>--}}
{{--        <h3>--}}
{{--            <a href="{{route('small_architectural_forms')}}">--}}
{{--                <button>Малые архитектурные формы</button>--}}
{{--            </a>--}}
{{--        </h3>--}}
{{--    </div>--}}
{{--    <div class="direction">--}}
{{--        <div class="direction__image">--}}
{{--            <img src="{{asset('/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/concrete_products1.webp')}}"--}}
{{--                 alt="{{$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/concrete_products1.webp'] ?? ''}}">--}}
{{--        </div>--}}
{{--        <h3>--}}
{{--            <a href="{{route('concrete_products')}}">--}}
{{--                <button>Изделия из бетона</button>--}}
{{--            </a>--}}
{{--        </h3>--}}
{{--    </div>--}}
</div>
