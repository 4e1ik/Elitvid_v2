@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <h1>Страница редактирования текстур</h1>
        </div>
        <div class="col-md-12 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        @if($image == !null)
                        <form action="{{ route('texture_image_destroy', ['image' => $image, 'texture' => $texture]) }}"
                              method="post">
                            @method('DELETE')
                            @csrf
                            <img style="height: 200px; border-radius:15px"
                                 src="{{ asset('storage/'.$image->image) }}" alt="">
                            <button type="submit" style="border: 0;">
                                <input type="button" class="btn btn-3d btn-danger" value="Удалить">
                            </button>
                        </form>
                        <form action="{{ route('texture_image_update', ['image' => $image, 'texture' => $texture]) }}"
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
                            <button type="submit" style="border: 0; margin-bottom: 20px;">
                                <input type="button" class="btn btn-3d" value="Отредактировать описание">
                            </button>
                        </form>
                        <div class="box col-md-5 bg-grey" style="margin-bottom: 20px;"></div>
                        <div class="box col-md-7" style="margin-bottom: 20px;"></div>
                            @endif
                    </div>
                </div>
            </div>
        </div>
        <form action="{{route('textures.update', ['texture' => $texture])}}" enctype="multipart/form-data"
              method="post">
            @method('PUT')
            @csrf
            @if($image == null)
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
            @endif
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="form-group">
                                <h3>Отредактировать название текстуры</h3>
                                <div class="col-md-5 padding-0">
                                    <input class="form-control {{$errors->has('texture_name') ? 'danger' : ''}}"
                                           type="text" name="texture_name"
                                           value="{{$errors->has('texture_name') ? old('texture_name') : $texture->texture_name}}">
                                </div>
                            </div>
                            @error('texture_name')
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
                            <h3>Раздел</h3>
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
                            <input type="submit" class="btn  btn-3d btn-success" value="Обновить">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
