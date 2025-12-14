@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <h1>Редактирование статической страницы</h1>
        </div>
        <form action="{{route('static_pages.update', ['static_page' => $staticPage])}}" enctype="multipart/form-data" method="post">
            @method('PUT')
            @csrf
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <h3>Идентификатор страницы</h3>
                            <input type="text" class="form-control" value="{{$staticPage->page}}" readonly disabled>
                            <small class="text-muted">Идентификатор нельзя изменить</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <h3>Заголовок (H1)</h3>
                            <textarea class="form-control" name="title" rows="3" placeholder="Например: Каменные ротонды и колонны">{{$staticPage->title}}</textarea>
                            @error('title')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <h3>Описание</h3>
                            <textarea class="form-control" name="description" id="editor" rows="10" placeholder="Текст описания страницы">{{$staticPage->description}}</textarea>
                            <script>
                                tinymce.init({
                                    selector: '#editor',
                                    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                                });
                            </script>
                            @error('description')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="col-md-3">
                                <h3>Главная картинка</h3>
                                @if($staticPage->main_image)
                                    <div style="margin-bottom: 20px;">
                                        <img style="max-width: 100%; height: auto; max-height: 300px;" src="{{asset($staticPage->main_image)}}" alt="{{$staticPage->alt_image}}">
                                        <p><small>Текущее изображение</small></p>
                                    </div>
                                @endif
                                <label style="display: flex; justify-content: center; align-items: center;"
                                       for="main_image" class="dropzone dz-clickable">
                                    <span>Переместите файл сюда для загрузки</span>
                                </label>
                                <input style="display: none" id="main_image" type="file" name="main_image" accept="image/*">
                                @error('main_image')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-9">
                                <h3>Alt текст для картинки</h3>
                                <input type="text" class="form-control" name="alt_image" value="{{$staticPage->alt_image}}" placeholder="Описание изображения">
                                @error('alt_image')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <input type="submit" class="btn btn-3d btn-success" value="Сохранить">
                            <a href="{{route('static_pages.index')}}" class="btn btn-3d btn-default">Отмена</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

