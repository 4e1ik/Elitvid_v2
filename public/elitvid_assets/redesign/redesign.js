document.addEventListener("DOMContentLoaded", function () {
    var header = document.querySelector(".rd-header");
    var burger = document.querySelector(".rd-header__burger");
    var contacts = document.querySelector(".rd-header__contacts");
    var contactsToggle = document.querySelector(".rd-header__contacts-toggle");
    var form = document.querySelector(".rd-form");

    if (burger && header) {
        burger.addEventListener("click", function () {
            header.classList.toggle("is-open");
        });
    }

    if (contactsToggle && contacts) {
        contactsToggle.addEventListener("click", function (event) {
            event.stopPropagation();
            contacts.classList.toggle("is-open");
        });
    }

    document.addEventListener("click", function (event) {
        if (contacts && !contacts.contains(event.target)) {
            contacts.classList.remove("is-open");
        }
        if (form && event.target === form) {
            form.classList.remove("is-open");
        }
    });

    document.querySelectorAll(".open_popup_application, .open_popup_application1").forEach(function (button) {
        button.addEventListener("click", function () {
            if (form) {
                form.classList.add("is-open");
            }
        });
    });

    document.querySelectorAll("[data-rd-close]").forEach(function (button) {
        button.addEventListener("click", function () {
            if (form) {
                form.classList.remove("is-open");
            }
        });
    });
});
