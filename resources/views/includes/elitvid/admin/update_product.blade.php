@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <h1>Страница редактирования {{ $route_name && $route == 'benches' ? ('скамеек') : ($route_name && $route == 'pots' ? ('кашпо') : ($route_name && $route == 'textures' ? ('текстуры'):(( $route_name && $route == 'gallery' ? ('примеров работ') : (''))))) }}</h1>
        </div>
        <div class="col-md-12 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        @foreach($post as $item)
                            @foreach($item->images as $img)
                                <form action="{{ route('image_destory', ['id' => $img->id, 'post' => $item]) }}" method="post">
                                    <img style="height: 200px; border-radius:15px" src="{{ asset('storage/'.$img->image) }}" alt="">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" style="border: 0;">
                                        <input type="button" class="btn btn-3d btn-danger" value="Удалить">
                                    </button>
                                </form>
                                <form action="{{ route('image_update', ['id' => $img->id, 'post' => $item]) }}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <h3>Отредактировать описание</h3>
                                    <input type="text" name="description_img" value="{{$errors->has('description_img') ? old('description_img') : $img->description_img}}">
                                    @error('description_img')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                    <button type="submit" style="border: 0">
                                        <input type="button" class="btn btn-3d" value="Отредактировать описание">
                                    </button>
                                </form>

                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        <div class="form-group"><label class="col-md-2 control-label text-right">Normal</label>
                            <div class="col-md-5"><input type="text" class="form-control"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
        <div class="col-md-12 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        <h3>Добавить картинку</h3>
                        <input type="file" name="{{ $route_name && $route !== 'gallery' ? 'image[]' : 'image' }}" multiple="multiple" class="dropzone dz-clickable" id="my-awesome-dropzone">
                    </div>
                </div>
            </div>
        </div>
                @if( $route_name && $route !== 'gallery' )
        <div class="col-md-12 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        <div class="form-group">
                            <h3>Отредактировать заголовок</h3>
                            <div class="col-md-5 padding-0">
                                <input class="form-control {{$errors->has('title') ? 'danger' : ''}}" type="text" name="title" value="{{$errors->has('title') ? old('title') : $item->title}}">
                            </div>
                        </div>
                        @error('title')
                        <div class="col-md-12 text-danger padding-0">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        <h3>Отредактировать описание</h3>
                        <input  {{ $route_name && $route !== 'textures' ? 'id=input' : ''}} type="text" name="content" value="{{$errors->has('content') ? old('content') : $item->content}}">
                        @error('content')
                        <div class="text-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
                @endif
        <div class="col-md-12 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        <h3>Раздел</h3>
                        <select class="form-control" name="type">
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
                        @error('type')
                        <div class="text-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        <h3>Сделать активным?</h3>
                        <div class="form-group">
                            <div class="col-md-10">
                                <div class="col-md-12 padding-0">
                                    <input type="radio" name="active" value="1"> Да
                                </div>
                                <div class="col-md-12 padding-0">
                                    <input type="radio" name="active" value="0"> Нет
                                </div>
                            </div>
                        </div>
                        @error('active')
                        <div class="text-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        <input type="submit" class="btn  btn-3d btn-success" value="Обновить">
                    </div>
                </div>
            </div>
        </div>
        </form>
        @endforeach
    </div>
@endsection
