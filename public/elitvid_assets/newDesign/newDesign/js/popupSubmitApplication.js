let menuBtn = document.querySelector('.open_popup_application');
let menuBtn1 = document.querySelector('.open_popup_application1');
let popup = document.querySelector('.popup_application');
let crossBtn = document.querySelector('.popup__cross_application');


document.addEventListener('DOMContentLoaded', function () {
    var menuBtn = document.querySelectorAll('.open_popup_application');
    menuBtn.forEach(function (element) {
        element.addEventListener('click', function () {
            popup.style.display = 'block';
            document.body.classList.add('popup-open');
        });
    })
})

document.addEventListener('DOMContentLoaded', function () {
    var menuBtn1 = document.querySelectorAll('.open_popup_application1');
    menuBtn1.forEach(function (element) {
        element.addEventListener('click', function () {
            popup.style.display = 'block';
            document.body.classList.add('popup-open');
        });
    })
})

crossBtn.onclick = function () {
    popup.style.display = 'none';
    document.body.classList.remove('popup-open');
    document.getElementById('mail_form').reset();
};

window.onclick = function (event) {
    if (event.target === document.querySelector('.popup__body_application')) {
        popup.style.display = 'none';
        document.body.classList.remove('popup-open');
        document.getElementById('mail_form').reset();
    }
};

//Изменение состояния кнопки
document.addEventListener('DOMContentLoaded', function () {
    const checkbox = document.getElementById('personalDataConsent');
    const submitButton = document.querySelector('.form__form-button');

    if (!checkbox || !submitButton) {
        console.warn('Чекбокс или кнопка не найдены');
        return;
    }

    function updateButtonState() {
        if (checkbox.checked) {
            submitButton.classList.remove('disabled');
        } else {
            submitButton.classList.add('disabled');
        }
    }

    submitButton.classList.add('disabled');

    checkbox.addEventListener('change', function () {
        updateButtonState();
        this.closest('.form__checkbox').classList.remove('error');
    });
});
