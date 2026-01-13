document.addEventListener('DOMContentLoaded', () => {
    const panelBody = document.getElementById('panel-body');
    const tbody = document.getElementById('variants-tbody');
    const variantIndexData = document.getElementById('variants-tbody');
    let variantIndex = variantIndexData ? variantIndexData.querySelectorAll('.variant-row').length : 1;
    
    const imagesInput = document.getElementById('images');
    const imagePreviewContainer = document.getElementById('image-preview-container');
    const imageFiles = [];
    let imageIndex = 0;

    // Обработка загрузки изображений
    if (imagesInput && imagePreviewContainer) {
        imagesInput.addEventListener('change', function(e) {
            const newFiles = Array.from(e.target.files);
            
            newFiles.forEach((file) => {
                if (file.type.startsWith('image/')) {
                    const currentIndex = imageIndex;
                    imageFiles.push(file);
                    
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const previewDiv = document.createElement('div');
                        previewDiv.className = 'image-preview-item';
                        previewDiv.style.cssText = 'width: 250px; margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px; background: #fafafa;';
                        previewDiv.setAttribute('data-image-index', currentIndex);
                        
                        previewDiv.innerHTML = `
                            <div style="margin-bottom: 10px; position: relative;">
                                <img src="${event.target.result}" style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd;" alt="Preview">
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label style="font-size: 13px; font-weight: 500; display: block; margin-bottom: 5px;">Описание</label>
                                <input type="text" class="form-control" name="image_data[${currentIndex}][description_image]" placeholder="Описание изображения">
                            </div>
                            <button type="button" class="btn btn-danger btn-sm remove-image" style="width: 100%;">
                                <span class="fa fa-trash"></span> Удалить
                            </button>
                        `;
                        
                        imagePreviewContainer.appendChild(previewDiv);
                        
                        // Обработчик удаления изображения
                        previewDiv.querySelector('.remove-image').addEventListener('click', function() {
                            const indexToRemove = parseInt(previewDiv.getAttribute('data-image-index'));
                            imageFiles.splice(indexToRemove, 1);
                            previewDiv.remove();
                            
                            // Обновляем все индексы в оставшихся элементах
                            imagePreviewContainer.querySelectorAll('.image-preview-item').forEach((item, newIndex) => {
                                item.setAttribute('data-image-index', newIndex);
                                item.querySelectorAll('input, select').forEach(input => {
                                    const name = input.getAttribute('name');
                                    if (name) {
                                        input.setAttribute('name', name.replace(/image_data\[\d+\]/, `image_data[${newIndex}]`));
                                    }
                                });
                            });
                            
                            // Обновляем input file
                            const dt = new DataTransfer();
                            imageFiles.forEach(f => dt.items.add(f));
                            imagesInput.files = dt.files;
                        });
                        
                        imageIndex++;
                    };
                    reader.readAsDataURL(file);
                }
            });
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
                newRow.querySelectorAll('input[name*="variants"]').forEach((input) => {
                    const name = input.getAttribute('name');
                    input.setAttribute('name', name.replace(/variants\[\d+\]/, 'variants[' + variantIndex + ']'));
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
                        row.querySelectorAll('input[name*="variants"]').forEach((input) => {
                            const name = input.getAttribute('name');
                            const newName = name.replace(/variants\[\d+\]/, 'variants[' + index + ']');
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

