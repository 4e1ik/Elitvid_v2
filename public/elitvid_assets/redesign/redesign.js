document.addEventListener("DOMContentLoaded", function () {
    var header = document.querySelector(".rd-header");
    var burger = document.querySelector(".rd-header__burger");
    var contacts = document.querySelector(".rd-header__contacts");
    var contactsToggle = document.querySelector(".rd-header__contacts-toggle");
    var form = document.querySelector(".rd-form");

    if (burger && header) {
        var nav = header.querySelector(".rd-header__nav");
        var reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)");

        burger.addEventListener("click", function () {
            if (!header.classList.contains("is-open")) {
                header.classList.add("is-open");
                return;
            }
            if (reduceMotion.matches || !nav) {
                header.classList.remove("is-open");
                return;
            }
            // меню остаётся раскрытым, пока не доиграет анимация сворачивания
            header.classList.add("is-closing");
            nav.addEventListener("animationend", function done(event) {
                if (event.target !== nav) {
                    return; // анимация пунктов меню всплывает сюда же
                }
                nav.removeEventListener("animationend", done);
                header.classList.remove("is-open", "is-closing");
            });
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

    // выбор кода страны в стиле сайта; системный select скрыт и хранит отправляемое значение
    document.querySelectorAll('select[name="country"]').forEach(function (select) {
        var button = select.parentElement.querySelector(".rd-phone-code");
        var list = select.parentElement.querySelector(".rd-phone-list");
        if (!button || !list) {
            return;
        }
        var label = function (option) {
            var parts = option.textContent.trim().split(/\s+/);
            return [parts[0], parts.slice(1).join(" ").replace("+", "+ ")];
        };
        var fill = function (target, option) {
            var text = label(option);
            var flag = document.createElement("span");
            flag.textContent = text[0];
            var code = document.createElement("span");
            code.textContent = text[1];
            target.replaceChildren(flag, code);
        };
        var items = Array.prototype.filter.call(select.options, function (option) {
            return !option.disabled;
        }).map(function (option) {
            var item = document.createElement("li");
            item.setAttribute("role", "option");
            item.tabIndex = -1;
            fill(item, option);
            item.addEventListener("click", function () {
                choose(option);
            });
            list.appendChild(item);
            return { item: item, option: option };
        });
        var render = function () {
            var current = select.options[select.selectedIndex];
            fill(button, current);
            items.forEach(function (entry) {
                entry.item.setAttribute("aria-selected", entry.option === current ? "true" : "false");
            });
        };
        var close = function () {
            list.hidden = true;
            button.setAttribute("aria-expanded", "false");
        };
        var open = function () {
            list.hidden = false;
            button.setAttribute("aria-expanded", "true");
            var selected = list.querySelector('[aria-selected="true"]') || list.firstElementChild;
            if (selected) {
                selected.focus();
            }
        };
        var choose = function (option) {
            select.value = option.value;
            select.dispatchEvent(new Event("change"));
            close();
            button.focus();
        };
        button.addEventListener("click", function (event) {
            event.stopPropagation();
            list.hidden ? open() : close();
        });
        list.addEventListener("keydown", function (event) {
            var index = items.findIndex(function (entry) { return entry.item === document.activeElement; });
            if (event.key === "Escape") {
                close();
                button.focus();
            } else if (event.key === "ArrowDown" || event.key === "ArrowUp") {
                event.preventDefault();
                var next = items[(index + (event.key === "ArrowDown" ? 1 : items.length - 1)) % items.length];
                next.item.focus();
            } else if ((event.key === "Enter" || event.key === " ") && index > -1) {
                event.preventDefault();
                choose(items[index].option);
            }
        });
        document.addEventListener("click", function (event) {
            if (!list.hidden && !list.contains(event.target)) {
                close();
            }
        });
        select.addEventListener("change", render);
        render();
    });

    document.querySelectorAll("[data-rd-close]").forEach(function (button) {
        button.addEventListener("click", function () {
            if (form) {
                form.classList.remove("is-open");
            }
        });
    });
});
