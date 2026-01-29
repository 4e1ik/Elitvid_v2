@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Редактирование поста блога</h3>
                    <p class="animated fadeInDown">
                        <a href="{{ route('admin_blog') }}">← Вернуться к списку постов</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <h3>Редактирование: {{ $blog->title }}</h3>
                        <small class="text-muted">
                            Создан: {{ $blog->created_at->format('d.m.Y H:i') }} | 
                            Обновлен: {{ $blog->updated_at->format('d.m.Y H:i') }}
                        </small>
                    </div>
                    <div class="panel-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul style="margin-bottom: 0;">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('blogs.update', ['blog' => $blog]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Основная информация -->
                            <div class="panel" style="margin-bottom: 20px;">
                                <div class="panel-heading">
                                    <h4>Основная информация</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="title">
                                                    <strong>Заголовок поста</strong>
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input
                                                    type="text"
                                                    name="title"
                                                    id="title"
                                                    class="form-control @error('title') is-invalid @enderror"
                                                    value="{{ old('title', $blog->title) }}"
                                                    placeholder="Введите заголовок поста"
                                                    maxlength="255"
                                                    required
                                                >
                                                <small class="form-text text-muted">
                                                    Максимум 255 символов
                                                </small>
                                                @error('title')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>
                                                    <strong>Статус публикации</strong>
                                                </label>
                                                <div style="margin-top: 10px;">
                                                    <label style="display: inline-flex; align-items: center; gap: 8px; margin-right: 20px;">
                                                        <input type="radio" name="active" value="1" {{ old('active', $blog->active) == 1 ? 'checked' : '' }}>
                                                        <span>Опубликован</span>
                                                    </label>
                                                    <label style="display: inline-flex; align-items: center; gap: 8px;">
                                                        <input type="radio" name="active" value="0" {{ old('active', $blog->active) == 0 ? 'checked' : '' }}>
                                                        <span>Черновик</span>
                                                    </label>
                                                </div>
                                                @error('active')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">
                                            <strong>Краткое описание</strong>
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea
                                            name="description"
                                            id="description"
                                            class="form-control @error('description') is-invalid @enderror"
                                            rows="3"
                                            placeholder="Краткое описание поста (будет отображаться в списке постов)"
                                            maxlength="500"
                                            required
                                        >{{ old('description', $blog->description) }}</textarea>
                                        <small class="form-text text-muted">
                                            Максимум 500 символов. Это описание будет отображаться в списке постов.
                                        </small>
                                        @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Главное изображение -->
                            <div class="panel" style="margin-bottom: 20px;">
                                <div class="panel-heading">
                                    <h4>Главное изображение</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @php
                                                $mainImage = $blog->images()->where('main_image', true)->first();
                                                $imagePath = $mainImage ? $mainImage->image : ($blog->attributes['main_image'] ?? null);
                                            @endphp
                                            @if($imagePath)
                                                <div style="margin-bottom: 15px;">
                                                    <label style="font-weight: bold; display: block; margin-bottom: 10px;">Текущее изображение:</label>
                                                    <div style="border: 1px solid #ddd; border-radius: 5px; padding: 10px; background: #fff; position: relative;">
                                                        <a href="{{ asset('storage/' . str_replace('public/', '', $imagePath)) }}" target="_blank">
                                                            <img
                                                                src="{{ asset('storage/' . str_replace('public/', '', $imagePath)) }}"
                                                                alt="Главное изображение поста"
                                                                style="width: 100%; max-height: 300px; object-fit: contain; border-radius: 4px; cursor: pointer; transition: transform 0.3s;"
                                                                onmouseover="this.style.transform='scale(1.05)'"
                                                                onmouseout="this.style.transform='scale(1)'"
                                                            >
                                                        </a>
                                                        <div style="position: absolute; top: 15px; right: 15px; background: rgba(0,0,0,0.6); color: white; padding: 5px 10px; border-radius: 3px; font-size: 12px;">
                                                            <span class="fa fa-expand"></span> Клик для просмотра
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="form-group">
                                                <label for="main_image" style="display: flex; justify-content: center; align-items: center; padding: 40px; border: 2px dashed #ddd; border-radius: 5px; cursor: pointer; background: #fafafa; transition: all 0.3s;"
                                                       onmouseover="this.style.borderColor='#337ab7'; this.style.background='#f0f8ff';"
                                                       onmouseout="this.style.borderColor='#ddd'; this.style.background='#fafafa';">
                                                    <div style="text-align: center;">
                                                        <span class="fa fa-upload" style="font-size: 48px; color: #999; display: block; margin-bottom: 10px;"></span>
                                                        <span style="color: #666;">{{ $imagePath ? 'Заменить изображение' : 'Нажмите для выбора изображения' }}</span>
                                                        <br>
                                                        <small style="color: #999;">Рекомендуемый размер: 1200x600px</small>
                                                    </div>
                                                </label>
                                                <input
                                                    style="display: none"
                                                    id="main_image"
                                                    type="file"
                                                    name="main_image"
                                                    accept="image/*"
                                                    onchange="previewMainImage(this)"
                                                >
                                                @error('main_image')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div id="main-image-preview" style="display: none;">
                                                <div style="border: 1px solid #ddd; border-radius: 5px; padding: 10px; background: #fff;">
                                                    <label style="font-weight: bold; display: block; margin-bottom: 10px;">Новое изображение (превью):</label>
                                                    <img
                                                        id="main-image-preview-img"
                                                        src=""
                                                        alt="Превью главного изображения"
                                                        style="width: 100%; max-height: 300px; object-fit: contain; border-radius: 4px;"
                                                    >
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-danger"
                                                        style="width: 100%; margin-top: 10px;"
                                                        onclick="removeMainImagePreview()"
                                                    >
                                                        <span class="fa fa-times"></span> Отменить замену
                                                    </button>
                                                </div>
                                            </div>
                                            <div id="main-image-placeholder" style="text-align: center; padding: 40px; color: #999; {{ $imagePath ? 'display: none;' : '' }}">
                                                <span class="fa fa-image" style="font-size: 64px; display: block; margin-bottom: 10px;"></span>
                                                <span>Превью изображения появится здесь</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Мета-теги (SEO) -->
                            <div class="panel" style="margin-bottom: 20px;">
                                <div class="panel-heading">
                                    <h4>Мета-теги (SEO)</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="meta_title">
                                            <strong>Meta Title</strong>
                                        </label>
                                        <input
                                            type="text"
                                            name="meta_title"
                                            id="meta_title"
                                            class="form-control @error('meta_title') is-invalid @enderror"
                                            value="{{ old('meta_title', $blog->meta_title) }}"
                                            placeholder="Заголовок для поисковых систем"
                                            maxlength="255"
                                        >
                                        <small class="form-text text-muted">
                                            Максимум 255 символов. Если не указано, будет использован заголовок поста.
                                        </small>
                                        @error('meta_title')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_description">
                                            <strong>Meta Description</strong>
                                        </label>
                                        <textarea
                                            name="meta_description"
                                            id="meta_description"
                                            class="form-control @error('meta_description') is-invalid @enderror"
                                            rows="3"
                                            placeholder="Описание для поисковых систем"
                                            maxlength="500"
                                        >{{ old('meta_description', $blog->meta_description) }}</textarea>
                                        <small class="form-text text-muted">
                                            Максимум 500 символов. Если не указано, будет использовано краткое описание.
                                        </small>
                                        @error('meta_description')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Основной контент -->
                            <div class="panel" style="margin-bottom: 20px;">
                                <div class="panel-heading">
                                    <h4>Основной контент</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="editor">
                                            <strong>Содержание поста</strong>
                                        </label>
                                        <textarea
                                            id="editor"
                                            name="content"
                                            rows="20"
                                            class="form-control @error('content') is-invalid @enderror"
                                        >{{ old('content', $blog->content) }}</textarea>
                                        <script>
                                            tinymce.init({
                                                selector: '#editor',
                                                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                                                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                                                height: 500,
                                            });
                                        </script>
                                        @error('content')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Кнопки -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-3d btn-primary">
                                    <span class="fa fa-save"></span> Сохранить изменения
                                </button>
                                <a href="{{ route('admin_blog') }}" class="btn btn-default">
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

    <script>
        window.previewMainImage = function(input) {
            if (input && input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImg = document.getElementById('main-image-preview-img');
                    const previewDiv = document.getElementById('main-image-preview');
                    const placeholder = document.getElementById('main-image-placeholder');
                    const currentImageDiv = document.querySelector('.col-md-6:first-child > div:first-child');
                    
                    if (previewImg) {
                        previewImg.src = e.target.result;
                    }
                    if (previewDiv) {
                        previewDiv.style.display = 'block';
                    }
                    if (placeholder) {
                        placeholder.style.display = 'none';
                    }
                    // Скрываем текущее изображение при выборе нового
                    if (currentImageDiv && currentImageDiv.querySelector('img')) {
                        currentImageDiv.style.opacity = '0.5';
                    }
                };
                reader.onerror = function(error) {
                    alert('Ошибка при загрузке изображения. Пожалуйста, попробуйте еще раз.');
                };
                reader.readAsDataURL(input.files[0]);
            }
        };

        window.removeMainImagePreview = function() {
            const fileInput = document.getElementById('main_image');
            const previewDiv = document.getElementById('main-image-preview');
            const placeholder = document.getElementById('main-image-placeholder');
            const currentImageDiv = document.querySelector('.col-md-6:first-child > div:first-child');
            
            if (fileInput) {
                fileInput.value = '';
            }
            if (previewDiv) {
                previewDiv.style.display = 'none';
            }
            // Показываем placeholder только если нет текущего изображения
            const hasCurrentImage = currentImageDiv && currentImageDiv.querySelector('img');
            if (placeholder) {
                placeholder.style.display = hasCurrentImage ? 'none' : 'block';
            }
            // Восстанавливаем видимость текущего изображения
            if (currentImageDiv && currentImageDiv.querySelector('img')) {
                currentImageDiv.style.opacity = '1';
            }
        };
    </script>
@endsection
