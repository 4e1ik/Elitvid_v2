@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <h1>Страница создания текстуры</h1>
        </div>
        <form action="{{route('textures.store')}}"
              enctype="multipart/form-data" method="post">
            @csrf
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <h3>Картинка</h3>
                            <input type="file" name="image[]" class="dropzone dz-clickable col-md-5" id="my-awesome-dropzone">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <h3>Название текстуры</h3>
                            <div class="col-md-5 padding-0">
                                <input class="form-control {{$errors->has('texture_name') ? 'danger' : ''}}" type="text"
                                       name="texture_name" value="{{old('texture_name')}}">
                            </div>
                            @error('texture_name')
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
                                <option {{ $errors->has('type') ? '' : 'selected' }} disabled>Выберите раздел</option>
                                <option {{ old('type') == 'natural_stone' ? 'selected' : ''}} value="natural_stone">Натуральный камень</option>
                                <option {{ old('type') == 'moon_stone' ? 'selected' : ''}} value="moon_stone">Лунный камень</option>
                                <option {{ old('type') == 'polished_stone' ? 'selected' : ''}} value="polished_stone">Полированный камень</option>
                                <option {{ old('type') == 'wood_species' ? 'selected' : ''}} value="wood_species">Породы дерева</option>
                                <option {{ old('type') == 'wood_impregnation' ? 'selected' : ''}} value="wood_impregnation">Пропитка</option>
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
                            <input type="submit" class="btn  btn-3d btn-success" value="Создать">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
