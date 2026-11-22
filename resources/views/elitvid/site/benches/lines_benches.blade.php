@extends('layouts.elitvid.elitvid')

@section('body-class', 'rd-page')

@section('content')
    <x-elitvid.collection-page
        title="Коллекция Lines"
        text="Подходят для создания различных композиций в торговых центрах и на улице."
        hero="lines"
        catalog="/elitvid_assets/newDesign/newDesign/files/benches.pdf"
        :products="$products"
        product-route="show_bench_product"
        collection="lines"
        :page-content="$pageContent" />
@endsection
