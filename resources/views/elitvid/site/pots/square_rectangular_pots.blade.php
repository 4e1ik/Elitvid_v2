@extends('layouts.elitvid.elitvid')

@section('body-class', 'rd-page')

@section('content')
    <x-elitvid.collection-page
        title="Квадратные и прямоугольные кашпо"
        text="Композиция в таких формах смотрится очень стильно. Есть возможность добавить подсветку растений."
        hero="square"
        catalog="/elitvid_assets/newDesign/newDesign/files/pots.pdf"
        :products="$products"
        product-route="show_pot_product"
        collection="kvadratnye-i-pryamougolnye"
        :page-content="$pageContent" />
@endsection
