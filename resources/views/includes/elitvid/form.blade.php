<style>
    .popup__form {
        display: none;
        justify-content: center;
        position: fixed;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 2;
    }

    .popup__form .popup__form-content {
        margin-top: 7em;
        width: 20em;
        height: 30em;
        background-color: rgba(0, 0, 0, 0.75);

    }

    .popup__form .popup__form-content .popup__form-item{
        display: flex;
        justify-content: end;
    }

    .popup__form .popup__form-content .popup__form-form{
        display: flex;
        flex-direction: column;
    }

    .popup__form .popup__form-content .popup__form-form h4{
        display: flex;
        justify-content: center;
    }

    .popup__form .popup__form-content .popup__form-form form{
        text-align: center;
    }

    .popup__form .popup__form-content .popup__form-form form button{
        cursor: pointer;
        margin-top: 2em;
    }

    .popup__form .popup__form-content .popup__form-form form input{
        border-radius: 0.5em;
        margin-top: 1em;
        width: 16em;
    }

    .popup__form .popup__form-content .popup__form-form form textarea{
        resize: none;
        border-radius: 0.5em;
        margin-top: 1em;
        width: 16em;
    }

    .active{
        display: flex;
    }
</style>
<div class="popup__form" id="content">
    <div class="popup__form-content">
        <div class="popup__form-item" style="cursor: pointer;">
            <button class="button-close" style="cursor: pointer; color: white; background: none; border: none" id="close_form">&#10006</button>
        </div>
        <div class="popup__form-form">
            <h4>Заказать звонок</h4>
            <form action="" method="post" enctype="multipart/form-data">
                <input class="item-form" type="text" name="name" placeholder="  Ваше имя" required>
                <input class="item-form" type="text" name="email" placeholder="  Ваша почта" required>
                <input class="item-form" type="text" name="name-corp" placeholder="  Название организации">
                <input class="item-form" type="text" name="phone" placeholder="  Номер телефона">
                <input class="item-form" type="file" name="file" placeholder="">
                <br>
                Файл должен быть не более 512 кб
                <textarea name="item-form textarea" type="text" id="" rows="5" placeholder="  Комментарий"></textarea>
                <button
                    data-sitekey="reCAPTCHA_site_key"
                    data-callback='onSubmit'
                    data-action='submit'
                    type="submit" class="popup__form-button g-recaptcha">Заказать</button>
            </form>
        </div>
    </div>
</div>
