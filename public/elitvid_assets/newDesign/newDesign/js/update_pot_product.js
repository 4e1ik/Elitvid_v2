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
                    imageFiles.splice(indexToRemove, 1);
                    previewDiv.remove();
                    
                    // Пересоздаем все превью с правильными индексами
                    refreshImagePreviews();
                });
                
                resolve(previewDiv);
            };
            reader.readAsDataURL(file);
        });
    }
    
    // Функция для обновления всех превью с правильными индексами
    async function refreshImagePreviews() {
        imagePreviewContainer.innerHTML = '';
        imageIndex = 0;
        
        // Обновляем input file
        const dt = new DataTransfer();
        imageFiles.forEach(f => dt.items.add(f));
        imagesInput.files = dt.files;
        
        // Пересоздаем все превью
        for (let i = 0; i < imageFiles.length; i++) {
            const previewDiv = await createImagePreview(imageFiles[i], i);
            imagePreviewContainer.appendChild(previewDiv);
            imageIndex++;
        }
    }
    
    if (imagesInput && imagePreviewContainer) {
        imagesInput.addEventListener('change', async function(e) {
            const newFiles = Array.from(e.target.files);
            
            // Очищаем старые данные
            imageFiles.length = 0;
            imageIndex = 0;
            
            // Добавляем все новые файлы
            newFiles.forEach((file) => {
                if (file.type.startsWith('image/')) {
                    imageFiles.push(file);
                }
            });
            
            // Пересоздаем все превью с правильными индексами
            await refreshImagePreviews();
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
