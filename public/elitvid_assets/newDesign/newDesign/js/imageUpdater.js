document.addEventListener('DOMContentLoaded', () => {
    // const image = document.getElementById('image');
    const firstImage = document.getElementById('first_image'); //Картинка которая отображается везде

    let currentTexture = 'marble';
    let currentColor = 'ivory';

    const textures = document.querySelectorAll('.images_textures__images div');
    const colors = document.querySelectorAll('.images_colors__images div');
    const images = document.querySelectorAll('#image');

    images.forEach(image => {
        image.style.display = 'none';
    })

    textures.forEach(img => {
        img.addEventListener('click', () => {
            currentTexture = img.getAttribute('data-texture'); // Получаем значение картинки текстуры
            updateImage(currentColor, currentTexture); // Вызываем функцию и передаем туда значения текстуры и цвета
        });
    });

    colors.forEach(div => {
        div.addEventListener('click', () => {
            currentColor = div.getAttribute('data-color'); // Получаем значение картинки цвета
            updateImage(currentColor, currentTexture); // Вызываем функцию и передаем туда значения текстуры и цвета
        });
    });

    function updateImage(color, texture) {
        images.forEach(image => { // Перебираем все картинки
            if (image.getAttribute('data-color') === color && image.getAttribute('data-texture') === texture) { // Если картинка с таким цветом и текстурой есть
                firstImage.style.display = 'none'; // Скрываем главную картинку
                images.forEach(image => { // Перебираем все картинки еще раз
                    image.style.display = 'none'; // Скрываем каждую
                });
                image.style.display = 'block';  // Делаем картинку видимой
            }
        });
    }
});
