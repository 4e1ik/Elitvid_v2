// const test = document.getElementById('image')

// let img = '/1180x592.png';

// let newsrc = test.getAttribute('src')+img

// test.setAttribute('src', newsrc)
// console.log(test)


document.addEventListener('DOMContentLoaded', () => {
    const image = document.getElementById('image');
    const firstImage = document.getElementById('first_image');

    let currentTexture = 'marble';
    let currentColor = 'ivory';




    const textures = document.querySelectorAll('.images_textures__images img');
    const colors = document.querySelectorAll('.images_colors__images div');
    const images = document.querySelectorAll('#image');

    images.forEach(image => {
        image.style.display = 'none';
    })

    textures.forEach(img => {
        img.addEventListener('click', () => {
            currentTexture = img.getAttribute('data-texture');
            updateImage(currentColor, currentTexture);
        });
    });

    colors.forEach(div => {
        div.addEventListener('click', () => {
            currentColor = div.getAttribute('data-color');
            updateImage(currentColor, currentTexture);
        });
    });

    function updateImage(color, texture) {
        firstImage.style.display = 'none';
        images.forEach(image => {
            image.style.display = 'none';
        })
        images.forEach(image => {
            if (image.getAttribute('data-color') === color && image.getAttribute('data-texture') === texture) {
                image.style.display = 'block';
            }
        })
    }
});
