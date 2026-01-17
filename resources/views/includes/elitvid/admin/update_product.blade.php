@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <h1>Страница редактирования {{ $productType === 'pot' ? 'кашпо' : 'скамейки' }}</h1>
        </div>
        
        @if($product->images->isNotEmpty())
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <h3 style="margin-bottom: 20px;">Существующие изображения</h3>
                            <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                                @foreach($product->images as $image)
                                    <div class="col-md-3" style="padding: 15px; border: 1px solid #ddd; border-radius: 5px; background: #fafafa; margin-bottom: 20px;">
                                        <div style="margin-bottom: 10px;">
                                            <img style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd;"
                                                 src="{{asset('storage/'.str_replace('public/','',$image->image))}}" alt="">
                                        </div>
                                        <form action="{{ route('images.update', ['image' => $image]) }}" method="post">
                                            @method('PUT')
                                            @csrf
                                            <div style="margin-bottom: 10px;">
                                                <label style="font-size: 13px; font-weight: 500; display: block; margin-bottom: 5px;">Описание</label>
                                                <input type="text" class="form-control" name="description_image"
                                                       value="{{ old('existing_images.'.$image->id.'.description_image', $image->description_image) }}">
                                            </div>
                                            @if($productType === 'pot')
                                                <div style="margin-bottom: 10px;">
                                                    <label style="font-size: 13px; font-weight: 500; display: block; margin-bottom: 5px;">Цвет</label>
                                                    <select class="form-control" name="color">
                                                        <option value="" {{ !$image->color ? 'selected' : '' }} disabled>Выберите цвет</option>
                                                        <option value="grey" {{ $image->color == 'grey' ? 'selected' : '' }}>Серый</option>
                                                        <option value="graphite" {{ $image->color == 'graphite' ? 'selected' : '' }}>Графит</option>
                                                        <option value="black" {{ $image->color == 'black' ? 'selected' : '' }}>Черный</option>
                                                        <option value="white" {{ $image->color == 'white' ? 'selected' : '' }}>Белый</option>
                                                        <option value="ivory" {{ $image->color == 'ivory' ? 'selected' : '' }}>Слоновая кость</option>
                                                        <option value="sand" {{ $image->color == 'sand' ? 'selected' : '' }}>Песочный</option>
                                                        <option value="orange" {{ $image->color == 'orange' ? 'selected' : '' }}>Оранжевый</option>
                                                        <option value="olive" {{ $image->color == 'olive' ? 'selected' : '' }}>Оливка</option>
                                                        <option value="malachite" {{ $image->color == 'malachite' ? 'selected' : '' }}>Малахит</option>
                                                        <option value="white_blue" {{ $image->color == 'white_blue' ? 'selected' : '' }}>Голубой</option>
                                                        <option value="blue" {{ $image->color == 'blue' ? 'selected' : '' }}>Синий</option>
                                                        <option value="bronze" {{ $image->color == 'bronze' ? 'selected' : '' }}>Бронза</option>
                                                    </select>
                                                </div>
                                                <div style="margin-bottom: 10px;">
                                                    <label style="font-size: 13px; font-weight: 500; display: block; margin-bottom: 5px;">Текстура</label>
                                                    <select class="form-control" name="texture">
                                                        <option value="" {{ !$image->texture ? 'selected' : '' }} disabled>Выберите текстуру</option>
                                                        <option value="porous" {{ $image->texture == 'porous' ? 'selected' : '' }}>Пористая</option>
                                                        <option value="smooth" {{ $image->texture == 'smooth' ? 'selected' : '' }}>Гладкая</option>
                                                        <option value="marble" {{ $image->texture == 'marble' ? 'selected' : '' }}>Мрамор</option>
                                                        <option value="blitz" {{ $image->texture == 'blitz' ? 'selected' : '' }}>Блиц</option>
                                                        <option value="wild" {{ $image->texture == 'wild' ? 'selected' : '' }}>Дикий камень</option>
                                                    </select>
                                                </div>
                                            @endif
                                            <div style="margin-bottom: 10px;">
                                                <button type="submit" class="btn btn-primary btn-sm" style="width: 100%;">
                                                    <span class="fa fa-save"></span> Сохранить изменения
                                                </button>
                                            </div>
                                        </form>
                                        <form action="{{ route('images.destroy', ['image' => $image]) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" style="width: 100%;">
                                                <span class="fa fa-trash"></span> Удалить изображение
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        <form action="{{route('products.update', ['product' => $product])}}" enctype="multipart/form-data" method="post">
            @method('PUT')
            @csrf
            <input type="hidden" name="product_type" value="{{ $productType }}">
            
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <h3>Добавить новую картинку{{ $productType === 'pot' ? 'и' : '' }}</h3>
                            <div class="col-md-12" style="margin-bottom: 20px;">
                                <label style="display: flex; justify-content: center; align-items: center; padding: 20px; border: 2px dashed #ddd; border-radius: 5px; cursor: pointer; background: #fafafa;"
                                       for="images" class="dropzone dz-clickable">
                                    <span>Переместите {{ $productType === 'pot' ? 'файлы' : 'файл' }} сюда для загрузки</span>
                                </label>
                                <input style="display: none" id="images" type="file" name="image[]"
                                       @if($productType === 'pot') multiple="multiple" @endif accept="image/*">
                            </div>
                            @error('image')
                            <div class="text-danger" style="margin-top: 10px; margin-bottom: 10px;">
                                {{$message}}
                            </div>
                            @enderror
                            @error('image.*')
                            <div class="text-danger" style="margin-top: 10px; margin-bottom: 10px;">
                                {{$message}}
                            </div>
                            @enderror
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
                                               name="name"
                                               value="{{$errors->has('name') ? old('name') : $product->name}}">
                                        @error('name')
                                        <div class="text-danger" style="margin-top: 5px;">
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
            
            {{-- Подключаем специфичную форму в зависимости от типа продукта --}}
            @include('includes.elitvid.admin.update_' . $productType . '_form', ['product' => $product])
            
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
                                               name="meta_title" value="{{$errors->has('meta_title') ? old('meta_title') : $product->meta_title}}">
                                        @error('meta_title')
                                        <div class="text-danger" style="margin-top: 5px;">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-8 padding-0">
                                    <div class="col-md-12">
                                        <div class="col-md-8 padding-0">
                                            <h3>Meta Description</h3>
                                            <textarea name="meta_description" class="form-control {{$errors->has('meta_description') ? 'danger' : ''}}" style="width: 100%;" rows="10" type="text"
                                                      placeholder="Введите описание товара">{{$errors->has('meta_description') ? old('meta_description') : $product->meta_description}}</textarea>
                                            @error('meta_description')
                                            <div class="text-danger" style="margin-top: 5px;">
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
                                                <input type="radio" name="active" value="1" {{ ($errors->has('active') ? old('active') : $product->active) == 1 ? 'checked' : '' }}> Да
                                            </div>
                                            <div class="col-md-1 padding-0">
                                                <input type="radio" name="active" value="0" {{ ($errors->has('active') ? old('active') : $product->active) == 0 ? 'checked' : '' }}> Нет
                                            </div>
                                        </div>
                                    </div>
                                    @error('active')
                                    <div class="text-danger" style="margin-top: 5px;">
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
                            <input type="submit" class="btn btn-success" value="Обновить">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="{{asset('/elitvid_assets/newDesign/newDesign/js/update_' . $productType . '_product.js')}}"></script>
@endsection
