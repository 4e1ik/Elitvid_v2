@extends('layouts.elitvid.elitvid')

@section('body-class', 'rd-page')

@section('content')
    <x-elitvid.collection-page
        title="Круглые кашпо"
        text="Очень удобная форма для больших и маленьких растений. Подойдут как для лиственных так и для хвойных культур."
        hero="round"
        catalog="/elitvid_assets/newDesign/newDesign/files/pots.pdf"
        :products="$products"
        product-route="show_pot_product"
        collection="kruglye"
        :page-content="$pageContent" />
@endsection
