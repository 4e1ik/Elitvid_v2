@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <h1>Страница создания примеров работ</h1>
        </div>
        <form action="{{route('galleries.store')}}"
              enctype="multipart/form-data" method="post">
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
                            <h2>Раздел</h2>
                            <select class="form-control" name="type"
                                    id="">
                                <option {{ $errors->has('type') ? '' : 'selected' }} disabled>Выберите раздел</option>
                                <option {{ old('type') == 'pots' ? 'selected' : ''}} value="pots">Кашпо</option>
                                <option {{ old('type') == 'benches' ? 'selected' : ''}} value="benches">Скамейки</option>
                                <option {{ old('type') == 'main_page' ? 'selected' : ''}} value="main_page">Главная страница</option>
                                <option {{ old('type') == 'decorative_elements' ? 'selected' : ''}} value="decorative_elements">Декоративные элементы</option>
                                <option {{ old('type') == 'bollards' ? 'selected' : ''}} value="bollards">Болларды и ограждения</option>
                                <option {{ old('type') == 'parklets_and_naves' ? 'selected' : ''}} value="parklets_and_naves">Парклеты и навесы</option>
                                <option {{ old('type') == 'columns_and_panels' ? 'selected' : ''}} value="columns_and_panels">Столбы и накрывки</option>
                                <option {{ old('type') == 'facade_walls' ? 'selected' : ''}} value="facade_walls">Фасадная лепнина</option>
                                <option {{ old('type') == 'rotundas' ? 'selected' : ''}} value="rotundas">Ротонды</option>
                                <option {{ old('type') == 'maf' ? 'selected' : ''}} value="maf">Малые архитектурные формы</option>
                                <option {{ old('type') == 'concrete_products' ? 'selected' : ''}} value="concrete_products">Изделия из бетона</option>
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
