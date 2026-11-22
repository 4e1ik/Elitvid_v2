@extends('layouts.elitvid.elitvid')

@section('body-class', 'rd-page')

@section('content')
    <x-elitvid.collection-page
        title="Коллекция Stones"
        text="Идеальна для создания стильных пространств возле офисов и в парковых зонах."
        hero="stones"
        catalog="/elitvid_assets/newDesign/newDesign/files/benches.pdf"
        :products="$products"
        product-route="show_bench_product"
        collection="stones"
        :page-content="$pageContent" />
@endsection
