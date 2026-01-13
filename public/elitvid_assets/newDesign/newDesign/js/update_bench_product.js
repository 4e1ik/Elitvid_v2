document.addEventListener('DOMContentLoaded', () => {
    let imageIndex = 0;
    const imagesInput = document.getElementById('images');
    const imagePreviewContainer = document.getElementById('image-preview-container');
    const imageFiles = [];

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
});

