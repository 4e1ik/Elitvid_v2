@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <h1>Страница
                создания {{ $route_name == 'benches' ? ('скамеек') : ($route_name == 'pots' ? ('кашпо') : '') }}</h1>
        </div>
        <form action="{{ route('products.store')}}"
              enctype="multipart/form-data" method="post">
            @csrf
            @if($route_name == 'benches')
                <input type="hidden" value="bench" name="item">
            @elseif($route_name == 'pots')
                <input type="hidden" value="pot" name="item">
            @endif
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <h3>Картинка</h3>
                            <input type="file" name="image[]" multiple="multiple" class="dropzone dz-clickable col-md-5"
                                   id="my-awesome-dropzone">
                            @error('image')
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
                            <h3>Название товара</h3>
                            <div class="col-md-5 padding-0">
                                <input class="form-control {{$errors->has('title') ? 'danger' : ''}}" type="text"
                                       name="title" value="{{old('title')}}">
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
                            <h3>Описание товара</h3>
                            <div class="">
                                <input id="input" type="text"
                                       class="form-control" name="content" value="{{old('content')}}">
                            </div>
                            @error('content')
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
                            <h2>Раздел</h2>
                            <select class="form-control" name="type"
                                    id="">
                                @if($route_name == 'benches')
                                    <option {{ $errors->has('type') ? '' : 'selected' }} disabled>Выберите раздел</option>
                                    <option {{ old('type') == 'Stones' ? 'selected' : ''}}  value="Stones">Коллекция Stones</option>
                                    <option {{ old('type') == 'Radius' ? 'selected' : ''}} value="Radius">Коллекция Radius</option>
                                    <option {{ old('type') == 'Solo' ? 'selected' : ''}} value="Solo">Коллекция Solo</option>
                                    <option {{ old('type') == 'Outdoor' ? 'selected' : ''}} value="Outdoor">Коллекция Outdoor</option>
                                @elseif($route_name == 'pots')
                                    <option {{ $errors->has('type') ? '' : 'selected' }} disabled>Выберите раздел</option>
                                    <option {{ old('type') == 'Square' ? 'selected' : ''}} value="Square">Квадратное кашпо</option>
                                    <option {{ old('type') == 'Round' ? 'selected' : ''}}  value="Round">Круглое кашпо</option>
                                    <option {{ old('type') == 'Rectangular' ? 'selected' : ''}} value="Rectangular">Прямоугольные кашпо</option>
                                @endif
                            </select>
{{--                            {{old('type')}}--}}
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
