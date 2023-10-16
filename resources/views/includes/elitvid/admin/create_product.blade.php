@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <div id="content">
        <h1>Страница создания {{ $route_name == 'benches' ? ('скамеек') : ($route_name == 'pots' ? ('кашпо') : ($route_name == 'textures' ? ('текстуры'):($route_name == 'gallery' ? ('примеров работ'): ('')))) }}</h1>
        <form action="{{ $route_name == 'gallery' ? route('image_create') : route('posts.store')}}" enctype="multipart/form-data" method="post">
            @csrf
            @if($route_name == 'benches')
                <input name="item" type="hidden" value="2">
            @elseif($route_name == 'pots')
                <input name="item" type="hidden" value="1">
            @elseif($route_name == 'textures')
                <input name="item" type="hidden" value="4">
{{--            @elseif($route_name == 'gallery')--}}
{{--                <input name="item" type="hidden" value="5">--}}
            @elseif($route_name == 'catalog')
                <input name="item" type="hidden" value="3">
            @endif
            <h2>Картинка</h2>
            <input type="file" name="image[]" {{$route_name == 'textures' ? '' : 'multiple="multiple"'}}>
            @if( $route_name != 'gallery' )
                <h2>Заголовок</h2>
                <input type="text" name="title">
                <h2>Описание {{ $route_name == 'textures' ? 'картинки' : '' }}</h2>
                <input {{ $route_name != 'textures' ? 'id=input' : ''}} type="text" name="{{ $route_name == 'textures' ? 'description_img' : 'content' }}">
            @endif
            <h2>{{ $route_name == 'benches' ? ('Коллекция') : ($route_name == 'pots' ? ('Раздел') : ($route_name == 'textures' ? ('Текстура'):($route_name == 'gallery' ? ('Продукция'): ('')))) }}</h2>
            <select name="{{$route_name == 'gallery' ? 'type_img' : 'type'}}" id="">
                @if($route_name == 'benches')
                    <option selected disabled>Выберите коллекцию</option>
                    <option value="9">Коллекция Stones</option>
                    <option value="10">Коллекция Radius</option>
                    <option value="11">Коллекция Solo</option>
                    <option value="12">Коллекция Outdoor</option>
                @elseif($route_name == 'pots')
                    <option selected disabled>Выберите раздел</option>
                    <option value="1">Квадратное кашпо</option>
                    <option value="2">Круглое кашпо</option>
                    <option value="3">Прямоугольные кашпо</option>
                @elseif($route_name == 'textures')

                    <option selected disabled>Выберите текстуру</option>
                    <option value="4">Натуральный камень</option>
                    <option value="5">Лунный камень</option>
                    <option value="6">Полированный камень</option>
                    <option value="7">Породы дерева</option>
                    <option value="8">Пропитка</option>
                @elseif($route_name == 'gallery')
                    <option selected disabled>Выберите раздел</option>
                    <option value="13">Кашпо</option>
                    <option value="14">Скамейки</option>
                @endif
            </select>
            <h2>Показывать пост?</h2>
            <p><input type="checkbox" name="active" value="1">Да</p>
            <p><input type="checkbox" name="active" value="0">Нет</p>
            <button type="submit">Создать</button>
        </form>
    </div>
@endsection
