document.querySelectorAll('.js-add-to-cart').forEach((form) => {
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const button = form.querySelector('button');
        if (!button || button.disabled) {
            return;
        }

        button.disabled = true;
        const response = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        });

        if (!response.ok) {
            button.disabled = false;
            return;
        }

        const label = button.textContent;
        button.textContent = 'Добавлено';
        button.classList.add('is-added');
        document.querySelector('.js-cart-link')?.classList.add('is-bumped');

        setTimeout(() => {
            button.textContent = label;
            button.classList.remove('is-added');
            button.disabled = false;
            document.querySelector('.js-cart-link')?.classList.remove('is-bumped');
        }, 1200);
    });
});
