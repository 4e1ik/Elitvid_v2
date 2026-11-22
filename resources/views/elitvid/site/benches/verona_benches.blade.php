@extends('layouts.elitvid.elitvid')

@section('body-class', 'rd-page')

@section('content')
    <x-elitvid.collection-page
        title="Коллекция Verona"
        text="Коллекция с потрясающими природными формами, гармонично впишется в любой ландшафт. Включает в себя кашпо и мебель."
        hero="verona"
        catalog="/elitvid_assets/newDesign/newDesign/files/benches.pdf"
        :products="$products"
        product-route="show_bench_product"
        collection="verona"
        :page-content="$pageContent" />
@endsection
