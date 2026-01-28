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
                        <h3>Редактирование: {{ $pageContent->pageName }}</h3>
                        <small class="text-muted">Страница: {{ $pageContent->page }}</small>
                    </div>
                    <div class="panel-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin_page_contents.update', $pageContent) }}" method="post" enctype="multipart/form-data">
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
                                    @if($pageContent->gallery)
                                        <small class="text-muted">
                                            ID галереи: {{ $pageContent->gallery->id }}
                                            | Изображений: {{ $pageContent->gallery->images ? $pageContent->gallery->images->count() : 0 }}
                                        </small>
                                    @endif
                                </div>
                                <div class="panel-body">
                                    @if($pageContent->gallery)
                                        <div class="form-group" style="margin-bottom: 15px;">
                                            <label style="display: inline-flex; align-items: center; gap: 8px;">
                                                <input type="checkbox" name="gallery_active" value="1" {{ $pageContent->gallery->active ? 'checked' : '' }}>
                                                <span>Галерея активна</span>
                                            </label>
                                        </div>
                                    @endif


                                        @if($pageContent->gallery && $pageContent->gallery->images && $pageContent->gallery->images->count() > 0)
                                        <div class="row" style="margin-bottom: 20px;">
                                            @foreach($pageContent->gallery->images as $image)
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
                                                            <div class="form-group" style="margin-bottom: 10px;">
                                                                <label style="font-size: 12px; font-weight: bold; margin-bottom: 5px; display: block;">
                                                                    Описание:
                                                                </label>
                                                                <textarea
                                                                    id="gallery_image_description_edit_{{ $image->id }}"
                                                                    name="description_image_{{ $image->id }}"
                                                                    class="form-control"
                                                                    rows="2"
                                                                    style="font-size: 12px; resize: vertical;"
                                                                    placeholder="Введите описание изображения"
                                                                >{{ old('description_image', $image->description_image) }}</textarea>
                                                            </div>
                                                            <button type="button"
                                                                    class="btn btn-sm btn-primary"
                                                                    style="width: 100%; margin-bottom: 5px;"
                                                                    title="Сохранить описание"
                                                                    onclick="updateImageDescription({{ $image->id }}, '{{ route('admin_page_contents.update_image_description', ['pageContent' => $pageContent, 'imageId' => $image->id]) }}')">
                                                                <span class="fa fa-save"></span> Сохранить
                                                            </button>
                                                                <button type="button"
                                                                        class="btn btn-sm btn-danger"
                                                                        style="width: 100%;"
                                                                        onclick="deleteImage({{ $image->id }}, '{{ route('images.destroy', ['image' => $image]) }}', 'Удалить это изображение?')"
                                                                        title="Удалить изображение">
                                                                    <span class="fa fa-trash"></span> Удалить
                                                                </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="alert alert-info" style="margin-top: 20px;">
                                            <strong><span class="fa fa-info-circle"></span> Галерея настроена.</strong><br>
                                            <small>Всего изображений: {{ $pageContent->gallery->images->count() }}. Кликните на изображение для просмотра в полном размере.</small>
                                        </div>
                                    @else
                                        <div class="alert alert-warning">
                                            <strong><span class="fa fa-exclamation-triangle"></span> Галерея не настроена.</strong><br>
                                            <small>Для этой страницы пока нет изображений в галерее. Загрузите изображения ниже.</small>
                                        </div>
                                    @endif

                                    {{-- Добавление новых изображений --}}
                                    <div style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #ddd;">
                                        <h4 style="margin-bottom: 15px;">Добавить новые изображения в галерею</h4>
                                        <div class="form-group">
                                            <label style="display: flex; justify-content: center; align-items: center; padding: 20px; border: 2px dashed #ddd; border-radius: 5px; cursor: pointer; background: #fafafa;"
                                                   for="gallery_images" class="dropzone dz-clickable">
                                                <span><span class="fa fa-upload"></span> Переместите файлы сюда для загрузки (можно выбрать несколько)</span>
                                            </label>
                                            <input style="display: none" id="gallery_images" type="file" name="gallery_images[]" multiple accept="image/*">
                                        </div>
                                        <div id="gallery-preview-container" style="margin-top: 20px; display: flex; flex-wrap: wrap; gap: 20px; min-height: 50px;"></div>
                                        @error('gallery_images')
                                        <div class="text-danger" style="margin-top: 10px;">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                        @error('gallery_images.*')
                                        <div class="text-danger" style="margin-top: 10px;">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Функция для обновления описания изображения через AJAX
            window.updateImageDescription = function(imageId, url) {
                const input = document.getElementById('gallery_image_description_edit_' + imageId);
                if (!input) return;

                const description = input.value;
                const formData = new FormData();
                formData.append('description_image', description);
                formData.append('_method', 'PUT');
                formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{csrf_token()}}');

                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        return response.json().catch(() => ({success: true}));
                    }
                    throw new Error('Network response was not ok');
                })
                .then(data => {
                    alert('Описание успешно сохранено');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ошибка при сохранении описания');
                });
            };

            // Превью галереи
            const galleryImagesInput = document.getElementById('gallery_images');
            const galleryPreviewContainer = document.getElementById('gallery-preview-container');
            let galleryIndex = 0;

            if (galleryImagesInput && galleryPreviewContainer) {
                galleryImagesInput.addEventListener('change', function(e) {
                    const files = Array.from(e.target.files);

                    files.forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            const previewDiv = document.createElement('div');
                            previewDiv.className = 'gallery-preview-item';
                            previewDiv.style.cssText = 'position: relative; width: 200px; margin-bottom: 20px;';
                            previewDiv.dataset.index = galleryIndex;

                            previewDiv.innerHTML = `
                                <img src="${event.target.result}" style="width: 100%; height: auto; border: 1px solid #ddd; border-radius: 5px;" alt="Превью">
                                <button type="button" class="btn btn-danger btn-sm remove-gallery-image" style="position: absolute; top: 5px; right: 5px;">
                                    <span class="fa fa-times"></span>
                                </button>
                                <div style="margin-top: 10px;">
                                    <input type="text" class="form-control" name="gallery_descriptions[]" placeholder="Описание изображения">
                                </div>
                            `;

                            galleryPreviewContainer.appendChild(previewDiv);
                            galleryIndex++;
                        };
                        reader.readAsDataURL(file);
                    });
                });
            }

            // Удаление изображения из превью галереи
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-gallery-image')) {
                    e.target.closest('.gallery-preview-item').remove();
                }
            });

            // Функция для удаления изображения через AJAX
            window.deleteImage = function(imageId, url, confirmMessage) {
                if (!confirm(confirmMessage)) return;

                const formData = new FormData();
                formData.append('_method', 'DELETE');
                formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{csrf_token()}}');

                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Ошибка при удалении изображения');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ошибка при удалении изображения');
                });
            };
        });
    </script>
@endsection
