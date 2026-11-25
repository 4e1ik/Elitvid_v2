@extends('layouts.elitvid.elitvid')

@section('body-class', 'rd-page')

@section('content')
    <main>
        @include('includes.elitvid.popup_application')
        <section class="rd-hero rd-hero--catalog rd-hero--crumbs">
            <div class="rd-wrap">
                <x-elitvid.breadcrumbs />
                <h1>Вазоны и кашпо</h1>
                <p>Работаем по индивидуальным размерам, эскизам и чертежам, а также предоставляем Каталог готовых изделий</p>
                <div class="rd-hero__photo" role="img" aria-label="Кашпо и скамьи из полистоуна с подсветкой"></div>
                <div class="rd-hero__actions">
                    <button class="rd-btn rd-btn--accent open_popup_application" type="button">Оставить заявку</button>
                    <x-elitvid.download-catalog file="/elitvid_assets/newDesign/newDesign/files/pots.pdf" />
                </div>
            </div>
        </section>

        <div class="rd-wrap">
            <section class="rd-section">
                <h2>Формы</h2>
                <div class="rd-forms">
                    <x-elitvid.form-row :image="asset('/elitvid_assets/newDesign/newDesign/imgs/pots/forms/circle_pot.webp')" :alt="$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/pots/forms/circle_pot.webp'] ?? ''" title="Круглые" :href="route('round_pots')">
                        Очень удобная форма для больших и маленьких растений. Подойдут как для лиственных так и для хвойных культур.
                    </x-elitvid.form-row>
                    <x-elitvid.form-row :image="asset('/elitvid_assets/newDesign/newDesign/imgs/pots/forms/square_pot.webp')" :alt="$static_images_arr['/elitvid_assets/newDesign/newDesign/imgs/pots/forms/square_pot.webp'] ?? ''" title="Квадратные и прямоугольные" :href="route('square_rectangular_pots')">
                        Композиция в таких формах смотрится очень стильно. Есть возможность добавить подсветку растений.
                    </x-elitvid.form-row>
                </div>
            </section>
            @if($pageContent && $pageContent->category_description)
                <section class="rd-section rd-seo">{!! $pageContent->category_description !!}</section>
            @endif
            @if(isset($pageContent->gallery) && $pageContent->gallery->active)
                <x-elitvid.works title="Примеры работ" :images="$pageContent->gallery->images" />
            @endif
        </div>
    </main>
@endsection
