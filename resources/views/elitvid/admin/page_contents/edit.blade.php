@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Редактирование контента страницы</h3>
                    <p class="animated fadeInDown">
                        <a href="{{ route('admin_page_contents.index') }}">← Вернуться к списку</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <h3>Редактирование: {{ $pageName }}</h3>
                        <small class="text-muted">Страница: {{ $page }}</small>
                    </div>
                    <div class="panel-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin_page_contents.update', $page) }}" method="post">
                            @method('PUT')
                            @csrf

                            <!-- Мета-теги -->
                            <div class="panel" style="margin-bottom: 20px;">
                                <div class="panel-heading">
                                    <h4>Мета-теги (SEO)</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="meta_title">
                                            <strong>Заголовок (Title)</strong>
                                        </label>
                                        <textarea
                                            name="meta_title"
                                            id="meta_title"
                                            class="form-control"
                                            rows="2"
                                            maxlength="255"
                                        >{{ old('meta_title', $pageContent->meta_title) }}</textarea>
                                        <small class="form-text text-muted">
                                            Максимум 255 символов
                                        </small>
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_description">
                                            <strong>Описание (Description)</strong>
                                        </label>
                                        <textarea
                                            name="meta_description"
                                            id="meta_description"
                                            class="form-control"
                                            rows="3"
                                            maxlength="500"
                                        >{{ old('meta_description', $pageContent->meta_description) }}</textarea>
                                        <small class="form-text text-muted">
                                            Максимум 500 символов
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Описание категории -->
                            <div class="panel" style="margin-bottom: 20px;">
                                <div class="panel-heading">
                                    <h4>Описание категории</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="category_description">
                                            <strong>Описание</strong>
                                        </label>
                                        <textarea
                                            name="category_description"
                                            id="editor"
                                            class="form-control"
                                            rows="10"
                                        >{{ old('category_description', $pageContent->category_description) }}</textarea>
                                        <script>
                                            tinymce.init({
                                                selector: '#editor',
                                                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                                                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                                            });
                                        </script>
                                        <small class="form-text text-muted">
                                            Используйте редактор для форматирования текста
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Галерея -->
                            <div class="panel" style="margin-bottom: 20px;">
                                <div class="panel-heading">
                                    <h4>Галерея изображений</h4>
                                    @if($gallery)
                                        <small class="text-muted">ID галереи: {{ $gallery->id }} | Изображений: {{ isset($allImages) ? $allImages->count() : 0 }}</small>
                                    @elseif(isset($allImages) && $allImages->count() > 0)
                                        <small class="text-muted">Изображений: {{ $allImages->count() }}</small>
                                    @endif
                                </div>
                                <div class="panel-body">
                                    @if(isset($allImages) && $allImages && $allImages->count() > 0)
                                        <div class="row" style="margin-bottom: 20px;">
                                            @foreach($allImages as $image)
                                                <div class="col-md-3 col-sm-4 col-xs-6" style="margin-bottom: 20px;">
                                                    <div class="thumbnail" style="border: 1px solid #ddd; border-radius: 4px; padding: 10px; background: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                                        <a href="{{ asset('storage/' . str_replace('public/', '', $image->image)) }}" 
                                                           target="_blank" 
                                                           style="display: block; position: relative; overflow: hidden; border-radius: 4px;">
                                                            <img 
                                                                src="{{ asset('storage/' . str_replace('public/', '', $image->image)) }}" 
                                                                alt="{{ $image->description_image ?? 'Изображение' }}"
                                                                style="width: 100%; height: 250px; object-fit: cover; transition: transform 0.3s;"
                                                                onmouseover="this.style.transform='scale(1.05)'"
                                                                onmouseout="this.style.transform='scale(1)'"
                                                            >
                                                            <div style="position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.6); color: white; padding: 5px 10px; border-radius: 3px; font-size: 12px;">
                                                                <span class="fa fa-expand"></span>
                                                            </div>
                                                        </a>
                                                        <div class="caption" style="margin-top: 10px; padding: 0;">
                                                            <form action="{{ route('admin_page_contents.update_image_description', ['page' => $page, 'imageId' => $image->id]) }}" 
                                                                  method="post" 
                                                                  style="margin: 0;">
                                                                @method('PUT')
                                                                @csrf
                                                                <div class="form-group" style="margin-bottom: 10px;">
                                                                    <label style="font-size: 12px; font-weight: bold; margin-bottom: 5px; display: block;">
                                                                        Описание:
                                                                    </label>
                                                                    <textarea 
                                                                        name="description_image" 
                                                                        class="form-control" 
                                                                        rows="2"
                                                                        style="font-size: 12px; resize: vertical;"
                                                                        placeholder="Введите описание изображения"
                                                                    >{{ old('description_image', $image->description_image) }}</textarea>
                                                                </div>
                                                                <button type="submit" 
                                                                        class="btn btn-sm btn-primary" 
                                                                        style="width: 100%;"
                                                                        title="Сохранить описание">
                                                                    <span class="fa fa-save"></span> Сохранить
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="alert alert-info" style="margin-top: 20px;">
                                            <strong><span class="fa fa-info-circle"></span> Галерея настроена.</strong><br>
                                            <small>Всего изображений: {{ $allImages->count() }}. Кликните на изображение для просмотра в полном размере. Для управления изображениями используйте раздел "Картинки" в меню админ-панели.</small>
                                        </div>
                                    @else
                                        <div class="alert alert-warning">
                                            <strong><span class="fa fa-exclamation-triangle"></span> Галерея не настроена.</strong><br>
                                            <small>Для этой страницы пока нет изображений в галерее. Используйте раздел "Картинки" в меню админ-панели для загрузки изображений. После создания галереи она автоматически свяжется с этой страницей через полиморфную связь.</small>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Кнопки сохранения -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-3d btn-primary">
                                    Сохранить изменения
                                </button>
                                <a href="{{ route('admin_page_contents.index') }}" class="btn btn-default">
                                    Отмена
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end: content -->
@endsection
