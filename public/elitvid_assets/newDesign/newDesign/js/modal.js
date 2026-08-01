document.addEventListener('DOMContentLoaded', function () {
    const overlay = document.getElementById('cookieOverlay');
    const popup = document.getElementById('cookiePopup');
    const acceptBtn = document.getElementById('cookieAcceptBtn');
    const rejectBtn = document.getElementById('cookieRejectBtn');

    // ---------- Надёжная функция чтения cookie ----------
    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    // ---------- Функция установки cookie ----------
    function setCookie(name, value, days) {
        const d = new Date();
        d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
        document.cookie = name + '=' + value + '; expires=' + d.toUTCString() + '; path=/; SameSite=Lax';
    }

    // ---------- Проверка согласия ----------
    function getConsent() {
        let consent = getCookie('cookie_consent');
        if (consent) {
            console.log('Согласие из cookie:', consent);
            return consent;
        }
        consent = localStorage.getItem('cookie_consent');
        if (consent) {
            console.log('Согласие из localStorage:', consent);
            setCookie('cookie_consent', consent, 365);
            return consent;
        }
        return null;
    }

    // ---------- Сохранение согласия ----------
    function setConsent(value) {
        setCookie('cookie_consent', value, 365);
        localStorage.setItem('cookie_consent', value);
        console.log('Сохранено согласие:', value);
    }

    // ---------- Показать / скрыть окно ----------
    function showPopup() {
        overlay.style.display = 'block';
        popup.style.display = 'block';
        // НЕ блокируем прокрутку body
    }

    function hidePopup() {
        overlay.style.display = 'none';
        popup.style.display = 'none';
        // НЕ разблокируем прокрутку body (она и не была заблокирована)
    }

    // ---------- Основная логика ----------
    const currentConsent = getConsent();

    if (currentConsent) {
        hidePopup();
    } else {
        showPopup();
    }

    // ---------- Обработчики кнопок ----------
    acceptBtn.addEventListener('click', function () {
        setConsent('accepted');
        hidePopup();
    });

    rejectBtn.addEventListener('click', function () {
        setConsent('rejected');
        hidePopup();
    });

    console.log('Все cookie:', document.cookie);
});
