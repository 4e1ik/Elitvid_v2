@extends('layouts.elitvid.elitvid')

@section('body-class', 'rd-page')

@section('content')
    <x-elitvid.collection-page
        title="Коллекция Solo"
        text="Подойдёт для торговых центров, стильно впишется в любой дизайн-проект. Модели можно комбинировать между собой."
        hero="solo"
        catalog="/elitvid_assets/newDesign/newDesign/files/benches.pdf"
        :products="$products"
        product-route="show_bench_product"
        collection="solo"
        :page-content="$pageContent" />
@endsection
