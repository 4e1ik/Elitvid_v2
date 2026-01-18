document.addEventListener('DOMContentLoaded', () => {
    const panelBody = document.getElementById('panel-body');
    const addVariantContainer = document.getElementById('add-variant-container');
    const variantIndexData = document.getElementById('variants-tbody');
    let variantIndex = variantIndexData ? variantIndexData.querySelectorAll('.variant-row').length : 1;

    const tbody = document.getElementById('variants-tbody');
    const imagesInput = document.getElementById('images');
    const imagePreviewContainer = document.getElementById('image-preview-container');

    // Обработка загрузки изображений
    const imageFiles = [];
    let imageIndex = 0;
    
    // Функция для создания превью изображения
    function createImagePreview(file, index) {
        return new Promise((resolve) => {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const previewDiv = document.createElement('div');
                        previewDiv.className = 'image-preview-item';
                        previewDiv.style.cssText = 'width: 250px; margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px; background: #fafafa;';
                previewDiv.setAttribute('data-image-index', index);
                        
                        previewDiv.innerHTML = `
                            <div style="margin-bottom: 10px; position: relative;">
                                <img src="${event.target.result}" style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd;" alt="Preview">
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label style="font-size: 13px; font-weight: 500; display: block; margin-bottom: 5px;">Описание</label>
                        <input type="text" class="form-control" name="image_data[${index}][description_image]" placeholder="Описание изображения">
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label style="font-size: 13px; font-weight: 500; display: block; margin-bottom: 5px;">Цвет</label>
                        <select class="form-control" name="image_data[${index}][color]">
                                    <option value="" disabled selected>Выберите цвет</option>
                                    <option value="grey">Серый</option>
                                    <option value="graphite">Графит</option>
                                    <option value="black">Черный</option>
                                    <option value="white">Белый</option>
                                    <option value="ivory">Слоновая кость</option>
                                    <option value="sand">Песочный</option>
                                    <option value="orange">Оранжевый</option>
                                    <option value="olive">Оливка</option>
                                    <option value="malachite">Малахит</option>
                                    <option value="white_blue">Голубой</option>
                                    <option value="blue">Синий</option>
                                    <option value="bronze">Бронза</option>
                                </select>
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label style="font-size: 13px; font-weight: 500; display: block; margin-bottom: 5px;">Текстура</label>
                        <select class="form-control" name="image_data[${index}][texture]">
                                    <option value="" disabled selected>Выберите текстуру</option>
                                    <option value="porous">Пористая</option>
                                    <option value="smooth">Гладкая</option>
                                    <option value="marble">Мрамор</option>
                                    <option value="blitz">Блиц</option>
                                    <option value="wild">Дикий камень</option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm remove-image" style="width: 100%;">
                                <span class="fa fa-trash"></span> Удалить
                            </button>
                        `;
                        
                        // Обработчик удаления изображения
                        previewDiv.querySelector('.remove-image').addEventListener('click', function() {
                            const indexToRemove = parseInt(previewDiv.getAttribute('data-image-index'));
                    // Сохраняем данные ВСЕХ превью перед удалением
                    const savedData = new Map();
                    const previewItems = imagePreviewContainer.querySelectorAll('.image-preview-item');
                    previewItems.forEach((item) => {
                        const itemIndex = parseInt(item.getAttribute('data-image-index'));
                        if (itemIndex >= 0 && itemIndex < imageFiles.length) {
                            const file = imageFiles[itemIndex];
                            const fileKey = getFileKey(file);
                            savedData.set(fileKey, {
                                description_image: item.querySelector('input[name*="description_image"]')?.value || '',
                                color: item.querySelector('select[name*="color"]')?.value || '',
                                texture: item.querySelector('select[name*="texture"]')?.value || ''
                            });
                        }
                    });
                    
                    // Удаляем файл из массива
                            imageFiles.splice(indexToRemove, 1);
                    
                    // Пересоздаем все превью с правильными индексами и восстанавливаем данные
                    refreshImagePreviewsWithData(savedData);
                });

                resolve(previewDiv);
            };
            reader.readAsDataURL(file);
        });
    }

    // Функция для получения уникального ключа файла
    function getFileKey(file) {
        return `${file.name}_${file.size}_${file.lastModified}`;
    }

    // Функция для обновления всех превью из массива imageFiles
    async function refreshImagePreviews(savedDataMap = null) {
        // Если данные не переданы, сохраняем их из текущих превью
        if (!savedDataMap) {
            savedDataMap = new Map();
            const previewItems = imagePreviewContainer.querySelectorAll('.image-preview-item');
            
            previewItems.forEach((item) => {
                const index = parseInt(item.getAttribute('data-image-index'));
                if (index >= 0 && index < imageFiles.length) {
                    const file = imageFiles[index];
                    const fileKey = getFileKey(file);
                    savedDataMap.set(fileKey, {
                        description_image: item.querySelector('input[name*="description_image"]')?.value || '',
                        color: item.querySelector('select[name*="color"]')?.value || '',
                        texture: item.querySelector('select[name*="texture"]')?.value || ''
                    });
                }
            });
        }
        
        // Очищаем контейнер
        imagePreviewContainer.innerHTML = '';
        imageIndex = 0;
                            
        // Обновляем input file через DataTransfer
                            const dt = new DataTransfer();
                            imageFiles.forEach(f => dt.items.add(f));
                            imagesInput.files = dt.files;

        // Пересоздаем все превью из массива
        for (let i = 0; i < imageFiles.length; i++) {
            const file = imageFiles[i];
            const fileKey = getFileKey(file);
            const previewDiv = await createImagePreview(file, i);
            
            // Восстанавливаем сохраненные данные по уникальному ключу файла
            if (savedDataMap.has(fileKey)) {
                const data = savedDataMap.get(fileKey);
                const descInput = previewDiv.querySelector('input[name*="description_image"]');
                const colorSelect = previewDiv.querySelector('select[name*="color"]');
                const textureSelect = previewDiv.querySelector('select[name*="texture"]');
                
                if (descInput) descInput.value = data.description_image;
                if (colorSelect) colorSelect.value = data.color;
                if (textureSelect) textureSelect.value = data.texture;
            }
            
            imagePreviewContainer.appendChild(previewDiv);
                        imageIndex++;
        }
    }

    // Функция для обновления превью с переданными данными (используется при удалении)
    async function refreshImagePreviewsWithData(savedDataMap) {
        await refreshImagePreviews(savedDataMap);
    }

    if (imagesInput && imagePreviewContainer) {
        imagesInput.addEventListener('change', async function(e) {
            const newFiles = Array.from(e.target.files);
            
            if (newFiles.length === 0) {
                return;
            }

            // Добавляем новые файлы в массив (с проверкой на дубликаты по имени)
            newFiles.forEach((file) => {
                if (file.type.startsWith('image/')) {
                    // Проверяем, нет ли уже такого файла в массиве
                    const fileExists = imageFiles.some(existingFile => 
                        existingFile.name === file.name && 
                        existingFile.size === file.size &&
                        existingFile.lastModified === file.lastModified
                    );
                    
                    if (!fileExists) {
                        imageFiles.push(file);
                    }
                }
            });

            // Очищаем контейнер и пересоздаем все превью из массива
            // Это гарантирует, что все файлы будут отображены и данные сохранятся
            await refreshImagePreviews();

            // Очищаем input, чтобы можно было добавить те же файлы снова
            imagesInput.value = '';
        });
    }
    
    if (panelBody) {
        panelBody.addEventListener('click', (e) => {
            // Обработка кнопки добавления
            if (e.target.closest('.addButton')) {
                const variantRows = tbody.querySelectorAll('.variant-row');
                const lastRow = variantRows[variantRows.length - 1];
                const newRow = lastRow.cloneNode(true);

                // Очищаем значения полей
                newRow.querySelectorAll('input').forEach((input) => {
                    input.value = '';
                    input.classList.remove('danger');
                });

                // Удаляем сообщения об ошибках
                newRow.querySelectorAll('.text-danger').forEach((error) => {
                    error.remove();
                });

                // Обновляем имена полей с новым индексом
                newRow.querySelectorAll('input[name*="data"]').forEach((input) => {
                    const name = input.getAttribute('name');
                    input.setAttribute('name', name.replace(/data\[\d+\]/, 'data[' + variantIndex + ']'));
                });

                // Добавляем новую строку в tbody
                tbody.appendChild(newRow);

                variantIndex++;
            }

            // Обработка кнопки удаления
            if (e.target.closest('.closeButton')) {
                const variantRow = e.target.closest('.variant-row');
                const variantRows = tbody.querySelectorAll('.variant-row');

                if (variantRows.length > 1) {
                    variantRow.remove();

                    // Обновляем индексы в именах полей
                    tbody.querySelectorAll('.variant-row').forEach((row, index) => {
                        row.querySelectorAll('input[name*="data"]').forEach((input) => {
                            const name = input.getAttribute('name');
                            const newName = name.replace(/data\[\d+\]/, 'data[' + index + ']');
                            input.setAttribute('name', newName);
                        });
                    });
                } else {
                    alert('Нельзя удалить последний вариант.');
                }
            }
        });
    }
});

