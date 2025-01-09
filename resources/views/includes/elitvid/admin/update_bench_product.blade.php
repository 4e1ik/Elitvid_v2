@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <h1>Страница редактирования скамеек</h1>
        </div>
        @if($benchImages->isNotEmpty())
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            @foreach($benchImages as $benchImage)
                                <div class="col-md-3">
                                    <div class="col-md-12 padding-0">
                                        <form
                                            action="{{ route('bench_image_destroy', ['benchImage' => $benchImage, 'benchProduct' => $benchProduct]) }}"
                                            method="post">
                                            @method('DELETE')
                                            @csrf
                                            <img style="height: 200px; border-radius:15px"
                                                 src="{{asset('storage/'.str_replace('public/','',$benchImage->image))}}" alt="">
                                            <button type="submit" style="border: 0;">
                                                <input type="button" class="btn btn-3d btn-danger" value="Удалить">
                                            </button>
                                        </form>
                                        <form
                                            action="{{ route('bench_image_update', ['benchImage' => $benchImage, 'benchProduct' => $benchProduct]) }}"
                                            method="post">
                                            @method('PUT')
                                            @csrf
                                            <h3>Отредактировать описание</h3>
                                            <input type="text" name="description_image"
                                                   value="{{$errors->has('description_image') ? old('description_image') : $benchImage->description_image}}">
                                            @error('description_image')
                                            <div class="text-danger">
                                                {{$message}}
                                            </div>
                                            @enderror
                                            <button type="submit" style="border: 0; margin-bottom: 20px; margin-top: 20px">
                                                <input type="button" class="btn btn-3d" value="Отредактировать описание">
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <form action="{{route('benchProducts.update', ['benchProduct' => $benchProduct])}}" enctype="multipart/form-data"
              method="post">
            @method('PUT')
            @csrf
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="col-md-3">
                                <h3>Картинка</h3>
                                <label style="display: flex; justify-content: center; align-items: center;"
                                       for="images" class="dropzone dz-clickable">
                                    <span>Переместите файлы сюда для загрузки</span>
                                </label>
                                <input style="display: none" id="images" type="file" name="image[]"
                                       multiple="multiple" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="col-md-3 padding-0">
                                    <h3>Отредактировать название товара</h3>
                                    <div class="col-md-11 padding-0">
                                        <input class="form-control {{$errors->has('name') ? 'danger' : ''}}"
                                               type="text"
                                               name="name"
                                               value="{{$errors->has('name') ? old('name') : $benchProduct->name}}">
                                    </div>
                                    @error('name')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 padding-0">
                                    <h3>Материал</h3>
                                    <div class="col-md-11 padding-0">
                                        <input class="form-control {{$errors->has('material') ? 'danger' : ''}}"
                                               type="text"
                                               name="material"
                                               value="{{$errors->has('material') ? old('material') : $benchProduct->material}}">
                                    </div>
                                    @error('material')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <input name="size" type="hidden" value="">
                            <input name="weight" type="hidden" value="">
                            <input name="price" type="hidden" value="">
                            @for($i=1; $i<=5;  $i++)
                                <div style="margin-top: 20px" class="col-md-12">
                                    <h4 style="margin-bottom: -15px">Строка {{$i}}</h4>
                                    <div class="col-md-4 padding-0">
                                        <h3>Размер</h3>
                                        <div class="col-md-11 padding-0">
                                            <input class="form-control {{$errors->has('size'.$i) ? 'danger' : ''}}"
                                                   type="text"
                                                   name="size{{$i}}"
                                                   value="{{array_key_exists($i-1, $sizes) ? ($errors->has('size') ? old('size'.$i) : $sizes[$i-1]) : ''}}">
                                        </div>
                                        @error('size'.$i)
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 padding-0">
                                        <h3>Вес</h3>
                                        <div class="col-md-11 padding-0">
                                            <input
                                                    class="form-control {{$errors->has('weight'.$i) ? 'danger' : ''}}"
                                                    type="text"
                                                    name="weight{{$i}}"
                                                    value="{{array_key_exists($i-1, $weights) ? ($errors->has('weights') ? old('weights'.$i) : $weights[$i-1]) : ''}}">
                                        </div>
                                        @error('weight'.$i)
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 padding-0">
                                        <h3>Цена</h3>
                                        <div class="col-md-11 padding-0">
                                            <input class="form-control {{$errors->has('price'.$i) ? 'danger' : ''}}"
                                                   type="text"
                                                   name="price{{$i}}"
                                                   value="{{array_key_exists($i-1, $prices) ? ($errors->has('prices') ? old('prices'.$i) : $prices[$i-1]) : ''}}">
                                        </div>
                                        @error('price'.$i)
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="col-md-3 padding-0">
                                    <h2>Форма</h2>
                                    <select class="form-control" name="collection"
                                            id="">
                                        <option {{ $errors->has('collection') ? '' : 'selected' }} disabled>Выберите
                                            форму
                                        </option>
                                        <option {{ $benchProduct->collection == 'Verona' ? 'selected' : ''}} value="Verona">
                                            Коллекция Verona
                                        </option>
                                        <option {{ $benchProduct->collection == 'Stones' ? 'selected' : ''}}  value="Stones">
                                            Коллекция Stones
                                        </option>
                                        <option {{ $benchProduct->collection == 'lines' ? 'selected' : ''}} value="lines">
                                            Коллекция lines
                                        </option>
                                        <option {{ $benchProduct->collection == 'Solo' ? 'selected' : ''}} value="Solo">
                                            Коллекция Solo
                                        </option>
                                        <option {{ $benchProduct->collection == 'Street_furniture' ? 'selected' : ''}} value="Street_furniture">
                                            Коллекция Street furniture
                                        </option>
                                    </select>
                                    @error('collection')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-4 padding-0">
                                    <h3>Сделать активным?</h3>
                                    <div class="form-group">
                                        <div class="col-md-10">
                                            <div class="col-md-1 padding-0">
                                                <input type="radio" name="active" value="1"> Да
                                            </div>
                                            <div class="col-md-1 padding-0">
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
                </div>
            </div>
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="col-md-3 padding-0">
                                    <h3>Meta Title</h3>
                                    <div class="col-md-11 padding-0">
                                        <input class="form-control {{$errors->has('meta_title') ? 'danger' : ''}}"
                                               type="text"
                                               name="meta_title" value="{{$benchProduct->meta_title}}">
                                    </div>
                                    @error('meta_title')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-8 padding-0">
                                    <div class="col-md-12">
                                        <div class="col-md-8 padding-0">
                                            <h3>Meta Description</h3>
                                            <textarea name="meta_description" style="width: 100%;" rows="10" type="text"
                                                      placeholder="Введите описание товара">{{$errors->has('meta_description') ? 'danger' : $benchProduct->meta_description}}</textarea>
                                            @error('meta_description')
                                            <div class="text-danger">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
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
