@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <h1>Страница создания {{ $productType === 'pot' ? 'кашпо' : 'скамейки' }}</h1>
        </div>
        <form action="{{ route('products.store')}}" enctype="multipart/form-data" method="post">
            @csrf
            <input type="hidden" name="product_type" value="{{ $productType }}">
            
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <h3>Картинка{{ $productType === 'pot' ? 'и' : '' }}</h3>
                            <div class="col-md-12" style="margin-bottom: 20px;">
                                <label style="display: flex; justify-content: center; align-items: center; padding: 20px; border: 2px dashed #ddd; border-radius: 5px; cursor: pointer; background: #fafafa;"
                                       for="images" class="dropzone dz-clickable">
                                    <span>Переместите {{ $productType === 'pot' ? 'файлы' : 'файл' }} сюда для загрузки</span>
                                </label>
                                <input style="display: none" id="images" type="file" name="image[]"
                                       @if($productType === 'pot') multiple="multiple" @endif accept="image/*">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Подключаем специфичную форму в зависимости от типа продукта --}}
            @include('includes.elitvid.admin.create_' . $productType . '_form')
            
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
                                                      placeholder="Введите описание товара">{{old('meta_description')}}</textarea>
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
                            <div class="col-md-12">
                                <div class="col-md-4 padding-0">
                                    <h3>Сделать активным?</h3>
                                    <div class="form-group">
                                        <div class="col-md-10">
                                            <div class="col-md-1 padding-0">
                                                <input type="radio" name="active" value="1" {{ old('active') == 1 ? 'checked' : '' }}> Да
                                            </div>
                                            <div class="col-md-1 padding-0">
                                                <input type="radio" name="active" value="0" {{ old('active') == 0 ? 'checked' : '' }}> Нет
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
                            <input type="submit" class="btn btn-success" value="Создать">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="{{asset('/elitvid_assets/newDesign/newDesign/js/create_' . $productType . '_product.js')}}"></script>
@endsection
