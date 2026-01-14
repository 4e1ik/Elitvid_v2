@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <h1>Страница создания кашпо</h1>
        </div>
        <form action="{{ route('products.store')}}"
              enctype="multipart/form-data" method="post">
            @csrf
            <input type="hidden" name="product_type" value="pot">
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <h3>Картинки</h3>
                            <div class="col-md-12" style="margin-bottom: 20px;">
                                <label style="display: flex; justify-content: center; align-items: center; padding: 20px; border: 2px dashed #ddd; border-radius: 5px; cursor: pointer; background: #fafafa;"
                                       for="images" class="dropzone dz-clickable">
                                    <span>Переместите файлы сюда для загрузки</span>
                                </label>
                                <input style="display: none" id="images" type="file" name="image[]"
                                       multiple="multiple" accept="image/*">
                            </div>
                            <div id="image-preview-container" class="col-md-12" style="margin-top: 20px; display: flex; flex-wrap: wrap; gap: 20px; min-height: 50px;"></div>
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
                                    <h3>Название товара</h3>
                                    <div class="col-md-11 padding-0">
                                        <input class="form-control {{$errors->has('name') ? 'danger' : ''}}"
                                               type="text"
                                               name="name" value="{{old('name')}}">
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
                                               name="material" value="{{old('material')}}">
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
                        <div class="panel-body" id="panel-body">
                            <h3 style="margin-bottom: 20px;">Варианты товара</h3>

                            @php
                                $oldVariants = old('variants', [['size' => '', 'weight' => '', 'price' => '']]);
                                if (empty($oldVariants) || !is_array($oldVariants)) {
                                    $oldVariants = [['size' => '', 'weight' => '', 'price' => '']];
                                }
                            @endphp

                            <div class="responsive-table">
                                <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Размер</th>
                                            <th>Вес</th>
                                            <th>Цена</th>
                                            <th style="width: 80px; text-align: center;">Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody id="variants-tbody">
                            @foreach($oldVariants as $index => $variant)
                                            <tr class="variant-row">
                                                <td>
                                            <input class="form-control {{$errors->has('variants.'.$index.'.size') ? 'danger' : ''}}"
                                                   type="text"
                                                   name="variants[{{$index}}][size]"
                                                   value="{{ old('variants.'.$index.'.size', $variant['size'] ?? '') }}">
                                        @error('variants.'.$index.'.size')
                                                    <div class="text-danger" style="font-size: 11px; margin-top: 4px;">
                                            {{$message}}
                                        </div>
                                        @enderror
                                                </td>
                                                <td>
                                            <input class="form-control {{$errors->has('variants.'.$index.'.weight') ? 'danger' : ''}}"
                                                   type="text"
                                                   name="variants[{{$index}}][weight]"
                                                   value="{{ old('variants.'.$index.'.weight', $variant['weight'] ?? '') }}">
                                        @error('variants.'.$index.'.weight')
                                                    <div class="text-danger" style="font-size: 11px; margin-top: 4px;">
                                            {{$message}}
                                        </div>
                                        @enderror
                                                </td>
                                                <td>
                                            <input class="form-control {{$errors->has('variants.'.$index.'.price') ? 'danger' : ''}}"
                                                   type="text"
                                                   name="variants[{{$index}}][price]"
                                                   value="{{ old('variants.'.$index.'.price', $variant['price'] ?? '') }}">
                                        @error('variants.'.$index.'.price')
                                                    <div class="text-danger" style="font-size: 11px; margin-top: 4px;">
                                            {{$message}}
                                        </div>
                                        @enderror
                                                </td>
                                                <td style="text-align: center;">
                                                    <button type="button"
                                                            class="btn btn-danger btn-sm closeButton"
                                                            title="Удалить вариант">
                                                        <span class="fa fa-trash"></span>
                                                    </button>
                                                </td>
                                            </tr>
                            @endforeach
                                    </tbody>
                                </table>
                                </div>

                            <div style="margin-top: 15px;" id="add-variant-container">
                                <button type="button" class="btn btn-success addButton">
                                    <span class="fa fa-plus"></span> Добавить вариант
                                </button>
                            </div>

                            @error('variants')
                            <div class="text-danger" style="margin-top: 10px; font-size: 13px;">
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
                            <div class="col-md-12">
                                <div class="col-md-3 padding-0">
                                    <h2>Форма</h2>
                                    <select class="form-control" name="collection"
                                            id="">
                                            <option {{ $errors->has('type') ? '' : 'selected' }} disabled>Выберите форму</option>
                                            <option {{ old('type') == 'Square' ? 'selected' : ''}} value="Square">Квадратное кашпо</option>
                                            <option {{ old('type') == 'Round' ? 'selected' : ''}}  value="Round">Круглое кашпо</option>
                                            <option {{ old('type') == 'Rectangular' ? 'selected' : ''}} value="Rectangular">Прямоугольные кашпо</option>
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
                                               name="meta_title" value="{{old('meta_title')}}">
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
                                                      placeholder="Введите описание товара">{{$errors->has('meta_description') ? 'danger' : old('meta_description')}}</textarea>
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
                            <input type="submit" class="btn  btn-3d btn-success" value="Создать">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="{{asset('/elitvid_assets/newDesign/newDesign/js/create_pot_product.js')}}"></script>
@endsection
