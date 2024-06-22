@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <h1>Страница
                редактирования {{ $route_name == 'benches' ? ('скамеек') : ($route_name == 'pots' ? ('кашпо') : '') }}</h1>
        </div>
        <div class="col-md-12 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        @foreach($images as $image)
                            <form action="{{ route('image_destroy', ['image' => $image, 'product' => $product]) }}"
                                  method="post">
                                @method('DELETE')
                                @csrf
                                <img style="height: 200px; border-radius:15px"
                                     src="{{ asset('storage/'.$image->image) }}" alt="">
                                <button type="submit" style="border: 0;">
                                    <input type="button" class="btn btn-3d btn-danger" value="Удалить">
                                </button>
                            </form>
                            <form action="{{ route('image_update', ['image' => $image, 'product' => $product]) }}"
                                  method="post">
                                @method('PUT')
                                @csrf
                                <h3>Отредактировать описание</h3>
                                <input type="text" name="description_image"
                                       value="{{$errors->has('description_image') ? old('description_image') : $image->description_image}}">
                                @error('description_image')
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                                @enderror
                                @if($product->item == 'pot')
                                <h3>Цвет</h3>
                                <select class="form-control" name="color"
                                        id="">
                                    <option {{ $errors->has('type') ? '' : 'selected' }} disabled>Выберите цвет</option>
                                    <option {{ old('type') == 'black' ? 'selected' : ''}} value="black">Черный</option>
                                    <option {{ old('type') == 'grey' ? 'selected' : ''}} value="grey">Серый</option>
                                    <option {{ old('type') == 'sandstone' ? 'selected' : ''}} value="sandstone">Песочный</option>
                                </select>
                                @error('type')
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                                @enderror
                                @endif
                                <button type="submit" style="border: 0; margin-bottom: 20px; margin-top: 20px">
                                    <input type="button" class="btn btn-3d" value="Отредактировать описание">
                                </button>
                            </form>
                            <div class="box col-md-5 bg-grey" style="margin-bottom: 20px;"></div>
                            <div class="box col-md-7" style="margin-bottom: 20px;"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <form action="{{route('products.update', ['product' => $product])}}" enctype="multipart/form-data"
              method="post">
            @method('PUT')
            @csrf
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <h3>Добавить картинку</h3>
                            <input type="file" name="image[]" multiple="multiple" class="dropzone dz-clickable"
                                   id="my-awesome-dropzone">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="form-group">
                                <h3>Отредактировать заголовок</h3>
                                <div class="col-md-5 padding-0">
                                    <input class="form-control {{$errors->has('title') ? 'danger' : ''}}"
                                           type="text" name="title"
                                           value="{{$errors->has('title') ? old('title') : $product->title}}">
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
                            <input id="input" type="text"
                                   name="content"
                                   value="{{$errors->has('content') ? old('content') : $product->content}}">
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
                            <h3>Раздел</h3>
                            <select class="form-control" name="type">
                                @if($product->item == 'bench')
                                    <option {{ $errors->has('type') ? '' : 'selected' }} disabled>Выберите раздел</option>
                                    <option {{ old('type') == 'Stones' ? 'selected' : ''}}  value="Stones">Коллекция Stones</option>
                                    <option {{ old('type') == 'Radius' ? 'selected' : ''}} value="Radius">Коллекция Radius</option>
                                    <option {{ old('type') == 'Solo' ? 'selected' : ''}} value="Solo">Коллекция Solo</option>
                                    <option {{ old('type') == 'Outdoor' ? 'selected' : ''}} value="Outdoor">Коллекция Outdoor</option>
                                @elseif($product->item == 'pot')
                                    <option {{ $errors->has('type') ? '' : 'selected' }} disabled>Выберите раздел</option>
                                    <option {{ old('type') == 'Square' ? 'selected' : ''}} value="Square">Квадратное кашпо</option>
                                    <option {{ old('type') == 'Round' ? 'selected' : ''}}  value="Round">Круглое кашпо</option>
                                    <option {{ old('type') == 'Rectangular' ? 'selected' : ''}} value="Rectangular">Прямоугольные кашпо</option>
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
    </div>
@endsection
