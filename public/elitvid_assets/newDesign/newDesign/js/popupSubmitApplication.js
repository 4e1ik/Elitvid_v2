let menuBtn = document.querySelector('.open_popup_application');
let menuBtn1 = document.querySelector('.open_popup_application1');
let popup = document.querySelector('.popup_application');
let crossBtn = document.querySelector('.popup__cross_application');


document.addEventListener('DOMContentLoaded', function () {
    var menuBtn = document.querySelectorAll('.open_popup_application');
    menuBtn.forEach(function (element) {
        element.addEventListener('click', function () {
            popup.style.display = 'block';
        });
    })
})

document.addEventListener('DOMContentLoaded', function () {
    var menuBtn1 = document.querySelectorAll('.open_popup_application1');
    menuBtn1.forEach(function (element) {
        element.addEventListener('click', function () {
            popup.style.display = 'block';
        });
    })
})

crossBtn.onclick = function () {
    popup.style.display = 'none';
};

window.onclick = function (event) {
    if (event.target === document.querySelector('.popup__body_application')) {
        popup.style.display = 'none';
    }
};
