@extends('layouts.elitvid.admin.admin')

@section('admin_content')
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Создание новой статической страницы</h3>
                </div>
            </div>
        </div>
        <form action="{{route('static_pages.store')}}" enctype="multipart/form-data" method="post">
            @csrf
            
            {{-- Заголовок и подзаголовок в одном блоке --}}
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="col-md-6 padding-0" style="padding-right: 15px;">
                                <h3>Заголовок (H1)</h3>
                                <input type="text" class="form-control @error('title') danger @enderror" name="title" id="title" value="{{old('title')}}" placeholder="Например: Болларды и ограждения">
                                @error('title')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 padding-0" style="padding-left: 15px;">
                                <h3>Подзаголовок (описание заголовка)</h3>
                                <textarea class="form-control @error('subtitle') danger @enderror" name="subtitle" rows="3" placeholder="Краткое описание страницы">{{old('subtitle')}}</textarea>
                                @error('subtitle')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Slug --}}
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <h3>
                                Slug (уникальный идентификатор)
                                <span class="fa fa-question-circle" style="cursor: pointer; color: #337ab7;" 
                                      data-toggle="tooltip" 
                                      data-placement="right" 
                                      title="Slug используется в URL страницы. Должен содержать только латинские буквы, цифры и подчеркивания. Можно сгенерировать в интернете из русского текста при желании."></span>
                            </h3>
                            <input type="text" class="form-control @error('slug') danger @enderror" name="slug" id="slug" value="{{old('slug')}}" placeholder="например: bollards_and_fencing">
                            <small class="text-muted">
                                <span class="fa fa-info-circle"></span> Если оставить поле пустым, slug будет автоматически сгенерирован из заголовка.
                            </small>
                            @error('slug')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Главный текст --}}
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <h3>Главный текст</h3>
                            <textarea class="form-control @error('content') danger @enderror" name="content" id="editor" rows="10" placeholder="Основное содержание страницы">{{old('content')}}</textarea>
                            <script>
                                tinymce.init({
                                    selector: '#editor',
                                    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                                });
                            </script>
                            @error('content')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Главная картинка и картинка меню в одном блоке --}}
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="col-md-6 padding-0" style="padding-right: 15px;">
                                <h3>Главная картинка</h3>
                                <div class="col-md-12" style="margin-bottom: 20px;">
                                    <label style="display: flex; justify-content: center; align-items: center; padding: 20px; border: 2px dashed #ddd; border-radius: 5px; cursor: pointer; background: #fafafa;"
                                           for="main_image" class="dropzone dz-clickable">
                                        <span>Переместите файл сюда для загрузки</span>
                                    </label>
                                    <input style="display: none" id="main_image" type="file" name="main_image" accept="image/*">
                                </div>
                                <div id="main-image-preview" class="col-md-12" style="margin-top: 20px; display: none;">
                                    <div style="position: relative; display: inline-block;">
                                        <img id="main-image-preview-img" style="max-width: 100%; max-height: 300px; border: 1px solid #ddd; border-radius: 5px;" src="" alt="Превью главной картинки">
                                        <button type="button" id="remove-main-image" class="btn btn-danger btn-sm" style="position: absolute; top: 5px; right: 5px;">
                                            <span class="fa fa-times"></span>
                                        </button>
                                    </div>
                                    <div style="margin-top: 10px;">
                                        <label>Описание главной картинки</label>
                                        <input type="text" class="form-control" name="main_image_description" id="main_image_description" placeholder="Описание изображения">
                                    </div>
                                </div>
                                @error('main_image')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 padding-0" style="padding-left: 15px;">
                                <h3>Картинка меню</h3>
                                <div class="col-md-12" style="margin-bottom: 20px;">
                                    <label style="display: flex; justify-content: center; align-items: center; padding: 20px; border: 2px dashed #ddd; border-radius: 5px; cursor: pointer; background: #fafafa;"
                                           for="menu_image" class="dropzone dz-clickable">
                                        <span>Переместите файл сюда для загрузки</span>
                                    </label>
                                    <input style="display: none" id="menu_image" type="file" name="menu_image" accept="image/*">
                                </div>
                                <div id="menu-image-preview" class="col-md-12" style="margin-top: 20px; display: none;">
                                    <div style="position: relative; display: inline-block;">
                                        <img id="menu-image-preview-img" style="max-width: 100%; max-height: 300px; border: 1px solid #ddd; border-radius: 5px;" src="" alt="Превью картинки меню">
                                        <button type="button" id="remove-menu-image" class="btn btn-danger btn-sm" style="position: absolute; top: 5px; right: 5px;">
                                            <span class="fa fa-times"></span>
                                        </button>
                                    </div>
                                    <div style="margin-top: 10px;">
                                        <label>Описание картинки меню</label>
                                        <input type="text" class="form-control" name="menu_image_description" id="menu_image_description" placeholder="Описание изображения">
                                    </div>
                                </div>
                                <div style="margin-top: 20px;">
                                    <h4>Название в меню</h4>
                                    <input type="text" class="form-control @error('menu_name') danger @enderror" name="menu_name" value="{{old('menu_name')}}" placeholder="Название, которое будет отображаться в меню">
                                    @error('menu_name')
                                    <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                @error('menu_image')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Галерея изображений --}}
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <h3>Галерея изображений</h3>
                            <div class="form-check" style="margin-bottom: 20px;">
                                <input class="form-check-input" type="checkbox" name="gallery_active" id="gallery_active" value="1" {{old('gallery_active', true) ? 'checked' : ''}}>
                                <label class="form-check-label" for="gallery_active">
                                    Галерея активна
                                </label>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 20px;">
                                <label style="display: flex; justify-content: center; align-items: center; padding: 20px; border: 2px dashed #ddd; border-radius: 5px; cursor: pointer; background: #fafafa;"
                                       for="gallery_images" class="dropzone dz-clickable">
                                    <span>Переместите файлы сюда для загрузки</span>
                                </label>
                                <input style="display: none" id="gallery_images" type="file" name="gallery_images[]" multiple accept="image/*">
                            </div>
                            <div id="gallery-preview-container" class="col-md-12" style="margin-top: 20px; display: flex; flex-wrap: wrap; gap: 20px; min-height: 50px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Meta теги --}}
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="col-md-6 padding-0" style="padding-right: 15px;">
                                <h3>Meta заголовок (для SEO)</h3>
                                <input type="text" class="form-control @error('meta_title') danger @enderror" name="meta_title" value="{{old('meta_title')}}" placeholder="Meta заголовок для поисковых систем">
                                @error('meta_title')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 padding-0" style="padding-left: 15px;">
                                <h3>Meta описание (для SEO)</h3>
                                <textarea class="form-control @error('meta_description') danger @enderror" name="meta_description" rows="3" placeholder="Meta описание для поисковых систем">{{old('meta_description')}}</textarea>
                                @error('meta_description')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Активность --}}
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{old('active', true) ? 'checked' : ''}}>
                                <label class="form-check-label" for="active">
                                    Страница активна
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Кнопки --}}
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <input type="submit" class="btn btn-3d btn-success" value="Создать страницу">
                            <a href="{{route('static_pages.index')}}" class="btn btn-3d btn-default">Отмена</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Инициализация tooltip для знака вопроса
            if (typeof $ !== 'undefined') {
                $('[data-toggle="tooltip"]').tooltip();
            }

            // Автогенерация slug из заголовка, если slug пустой
            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');
            if (titleInput && slugInput) {
                titleInput.addEventListener('blur', function() {
                    if (!slugInput.value.trim()) {
                        // Простая транслитерация
                        let slug = this.value.toLowerCase()
                            .replace(/[а-яё]/g, function(match) {
                                const map = {
                                    'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo',
                                    'ж': 'zh', 'з': 'z', 'и': 'i', 'й': 'y', 'к': 'k', 'л': 'l', 'м': 'm',
                                    'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u',
                                    'ф': 'f', 'х': 'h', 'ц': 'ts', 'ч': 'ch', 'ш': 'sh', 'щ': 'sch',
                                    'ъ': '', 'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu', 'я': 'ya'
                                };
                                return map[match] || '';
                            })
                            .replace(/[^a-z0-9]+/g, '_')
                            .replace(/^_+|_+$/g, '');
                        slugInput.value = slug;
                    }
                });
            }

            // Превью главной картинки
            const mainImageInput = document.getElementById('main_image');
            const mainImagePreview = document.getElementById('main-image-preview');
            const mainImagePreviewImg = document.getElementById('main-image-preview-img');
            const removeMainImageBtn = document.getElementById('remove-main-image');

            if (mainImageInput && mainImagePreview && mainImagePreviewImg) {
                mainImageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            mainImagePreviewImg.src = event.target.result;
                            mainImagePreview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            if (removeMainImageBtn && mainImageInput && mainImagePreview) {
                removeMainImageBtn.addEventListener('click', function() {
                    mainImageInput.value = '';
                    mainImagePreview.style.display = 'none';
                });
            }

            // Превью картинки меню
            const menuImageInput = document.getElementById('menu_image');
            const menuImagePreview = document.getElementById('menu-image-preview');
            const menuImagePreviewImg = document.getElementById('menu-image-preview-img');
            const removeMenuImageBtn = document.getElementById('remove-menu-image');

            if (menuImageInput && menuImagePreview && menuImagePreviewImg) {
                menuImageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            menuImagePreviewImg.src = event.target.result;
                            menuImagePreview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            if (removeMenuImageBtn && menuImageInput && menuImagePreview) {
                removeMenuImageBtn.addEventListener('click', function() {
                    menuImageInput.value = '';
                    menuImagePreview.style.display = 'none';
                });
            }

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

            // Удаление изображения из галереи
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-gallery-image')) {
                    e.target.closest('.gallery-preview-item').remove();
                }
            });
        });
    </script>
@endsection
