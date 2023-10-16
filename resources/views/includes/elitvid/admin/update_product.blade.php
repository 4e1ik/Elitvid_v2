@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <div id="content">
        <h1>Страница редактирования {{ $route_name && $route == 'benches' ? ('скамеек') : ($route_name && $route == 'pots' ? ('кашпо') : ($route_name && $route == 'textures' ? ('текстуры'):(( $route_name && $route == 'gallery' ? ('примеров работ') : (''))))) }}</h1>
        @foreach($post as $item)
            @foreach($item->images as $img)
                <form action="{{ route('image_update', ['id' => $img->id, 'post' => $item]) }}" method="post">
                    @method('PUT')
                    @csrf
                    <h2>Отредактировать описание</h2>
                    <input type="text" name="description_img" value="{{old('description_img', $img->description_img)}}">
                    <button type="submit" style="border: 0">
                        <input type="button" class="btn btn-3d" value="Обновить">
                    </button>
                </form>
                <form action="{{ route('image_destory', ['id' => $img->id, 'post' => $item]) }}" method="post">
                    <img style="height: 200px" src="{{ asset('storage/'.$img->image) }}" alt="">
                    @method('DELETE')
                    @csrf
                    <button type="submit" style="border: 0">
                        <input type="button" class="btn btn-3d btn-danger" value="Удалить">
                    </button>
                </form>
            @endforeach
        @endforeach
        @foreach($post as $item)
        <form action="{{route('posts.update', ['post'=>$item->id])}}" enctype="multipart/form-data" method="post">
            @method('PUT')
            @csrf
            @if($route_name && $route === 'benches')
                <input name="item" type="hidden" value="2">
            @elseif($route_name && $route === 'pots')
                <input name="item" type="hidden" value="1">
            @elseif($route_name && $route === 'textures')
                <input name="item" type="hidden" value="4">
            @elseif($route_name && $route === 'gallery')
                <input name="item" type="hidden" value="5">
            @elseif($route_name && $route === 'catalog')
                <input name="item" type="hidden" value="3">
            @endif
            <h2>Добавить картинку</h2>
            <input type="file" name="{{ $route_name && $route !== 'gallery' ? 'image[]' : 'image' }}" multiple="multiple">
            @if( $route_name && $route !== 'gallery' )
                <h2>Отредактировать заголовок</h2>
                <input type="text" name="title" value="{{$item->title}}">
                <h2>Отредактировать описание</h2>
                <input {{ $route_name && $route !== 'textures' ? 'id=input' : ''}} type="text" name="content" value="{{$item->content}}">
            @endif
            <h2>{{ ($route_name && $route === 'benches' ? ('Коллекция') : ($route_name && $route === 'pots' ? ('Раздел') : ($route_name && $route === 'textures' ? ('Текстура'):($route_name && $route === 'gallery' ? ('Продукция'): (''))))) }}</h2>
            <select value="{{old('type', $item->type)}}"  name="type" id="">
                @if($route_name && $route === 'benches')
                    <option selected disabled>Выберите коллекцию</option>
                    <option value="9">Коллекция Stones</option>
                    <option value="10">Коллекция Radius</option>
                    <option value="11">Коллекция Solo</option>
                    <option value="12">Коллекция Outdoor</option>
                @elseif($route_name && $route === 'pots')
                    <option selected disabled>Выберите раздел</option>
                    <option value="1">Квадратное кашпо</option>
                    <option value="2">Круглое кашпо</option>
                    <option value="3">Прямоугольные кашпо</option>
                @elseif($route_name && $route === 'textures')
                    <option selected disabled>Выберите текстуру</option>
                    <option value="4">Натуральный камень</option>
                    <option value="5">Лунный камень</option>
                    <option value="6">Полированный камень</option>
                    <option value="7">Породы дерева</option>
                    <option value="8">Пропитка</option>
                @elseif($route_name && $route === 'gallery')
                    <option selected disabled>Выберите раздел</option>
                    <option value="13">Кашпо</option>
                    <option value="14">Скамейки</option>
                @endif
            </select>
            <h2>Показывать пост?</h2>
            <p><input type="checkbox" name="active" value="1">Да</p>
            <p><input type="checkbox" name="active" value="0">Нет</p>
            <button type="submit">Готово</button>
        </form>
        @endforeach
    </div>
@endsection
