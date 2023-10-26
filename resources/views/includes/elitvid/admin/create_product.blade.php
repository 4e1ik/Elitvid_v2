@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <h1>Страница
                создания {{ $route_name == 'benches' ? ('скамеек') : ($route_name == 'pots' ? ('кашпо') : ($route_name == 'textures' ? ('текстуры'):($route_name == 'gallery' ? ('примеров работ'): ('')))) }}</h1>
        </div>
        <form action="{{ $route_name == 'gallery' ? route('image_create') : route('posts.store')}}"
              enctype="multipart/form-data" method="post">
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
        <div class="col-md-12 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div  class="panel-body">
                        <h3>Картинка</h3>
                        <input type="file" name="image[]" {{$route_name == 'textures' ? '' : 'multiple="multiple"'}} class="dropzone dz-clickable col-md-5" id="my-awesome-dropzone">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        @if( $route_name != 'gallery' )
                            <h3>Заголовок</h3>
                            <div class="col-md-5 padding-0">
                                <input class="form-control {{$errors->has('title') ? 'danger' : ''}}" type="text" name="title" value="{{old('title')}}">
                            </div>
                            @error('title')
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
                            <h3>Описание {{ $route_name == 'textures' ? 'картинки' : '' }}</h3>
                            <div class="{{$route_name == 'textures' ? 'col-md-5 padding-0' : ''}}">
                            <input {{ $route_name != 'textures' ? 'id=input' : ''}} type="text"
                                   class="form-control {{$errors->has('description_img') ? 'danger' : ''}} {{ $route_name != 'textures' ? '' : ''}}" name="{{ $route_name == 'textures' ? 'description_img' : 'content' }}" value="{{old($route_name == 'textures' ? 'description_img' : 'content')}}">
                            </div>
                            @error('description_img')
                            <div class="text-danger">
                                {{$message}}
                            </div>
                            @enderror
                            @error('content')
                            <div class="text-danger">
                                {{$message}}
                            </div>
                            @enderror
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <h2>Раздел</h2>
                            <select class="form-control" name="{{$route_name == 'gallery' ? 'type_img' : 'type'}}" id="">
                                @if($route_name == 'benches')
                                    <option selected disabled>Выберите раздел</option>
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
                                    <option selected disabled>Выберите раздел</option>
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
                            @error('type_img')
                            <div class="text-danger">
                                {{$message}}
                            </div>
                            @enderror
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
                            <input type="submit" class="btn  btn-3d btn-success" value="Создать">
                        </div>
                    </div>
                </div>
            </div>





{{--            <h2>{{ $route_name == 'benches' ? ('Коллекция') : ($route_name == 'pots' ? ('Раздел') : ($route_name == 'textures' ? ('Текстура'):($route_name == 'gallery' ? ('Продукция'): ('')))) }}</h2>--}}



        </form>
    </div>
@endsection
