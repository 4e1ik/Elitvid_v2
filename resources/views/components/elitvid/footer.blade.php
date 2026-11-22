<footer class="rd-footer">
    <div class="rd-footer__grid">
        <a href="{{ route('home') }}">
            <img class="rd-footer__logo" src="{{ asset('/elitvid_assets/newDesign/newDesign/imgs/logo/logo-big.svg') }}" alt="Элитвид" width="128" height="114">
        </a>
        <div>
            <h2>Контакты</h2>
            <ul>
                <li>Пн-пт: 8.00-17.00</li>
                <li><a href="mailto:el_vid@mail.ru">el_vid@mail.ru</a></li>
                <li><a href="tel:+79104184777">+7 (910) 418 47 77</a></li>
                <li><a href="tel:+79190409605">+7 (919) 040 96 05</a></li>
                <li><a href="tel:+375297665012">+375 (29) 766 50 12</a></li>
                <li><a href="tel:+375297034014">+375 (29) 703 40 14</a></li>
            </ul>
        </div>
        <div>
            <h2>Каталог</h2>
            <div class="rd-footer__catalog">
                <a href="{{ route('pots') }}">Кашпо</a>
                <span>Урны</span>
                <span>Цветы</span>
                <a href="{{ route('static_page', ['slug' => 'kamennye-navesy-i-parklety']) }}">Парклеты, навесы</a>
                <span>Растения</span>
                <a href="{{ route('static_page', ['slug' => 'stolby-i-nakryvki-iz-kamnya']) }}">Столбы и накрывки</a>
                <a href="{{ route('benches') }}">Скамьи</a>
                <span>Навесы и беседки</span>
                <a href="{{ route('static_page', ['slug' => 'kamennye-rotondy-kolonny']) }}">Ротонды и колоннады</a>
                <a href="{{ route('flowerbeds') }}">Сборные клумбы</a>
            </div>
        </div>
    </div>
    <div class="rd-footer__mobile">
        <div class="rd-footer__pitch">
            <img src="{{ asset('/elitvid_assets/newDesign/newDesign/imgs/logo/logo-big.svg') }}" alt="Элитвид" width="72" height="64">
            <p>Воплотим Ваши идеи в реальность!</p>
        </div>
        <button class="rd-btn rd-btn--accent open_popup_application" type="button">Заказать звонок</button>
        <div class="rd-footer__cols">
            <div>
                <h2>Каталог</h2>
                <ul>
                    <li><a href="{{ route('pots') }}">Кашпо</a></li>
                    <li><span>Цветы</span></li>
                    <li><span>Растения</span></li>
                    <li><a href="{{ route('benches') }}">Скамьи</a></li>
                    <li><a href="{{ route('static_page', ['slug' => 'kamennye-rotondy-kolonny']) }}">Ротонды и колоннады</a></li>
                    <li><span>Урны</span></li>
                    <li><a href="{{ route('static_page', ['slug' => 'kamennye-navesy-i-parklety']) }}">Парклеты, навесы</a></li>
                    <li><a href="{{ route('static_page', ['slug' => 'stolby-i-nakryvki-iz-kamnya']) }}">Столбы и накрывки</a></li>
                    <li><span>Навесы и беседки</span></li>
                    <li><a href="{{ route('flowerbeds') }}">Сборные клумбы</a></li>
                </ul>
            </div>
            <div>
                <h2>Контакты</h2>
                <ul>
                    <li>Пн-пт: 8.00-17.00</li>
                    <li><a href="mailto:el_vid@mail.ru">el_vid@mail.ru</a></li>
                    <li><a href="tel:+79104184777">+7 (910) 418 47 77</a></li>
                    <li><a href="tel:+79190409605">+7 (919) 040 96 05</a></li>
                    <li><a href="tel:+375297665012">+375 (29) 766 50 12</a></li>
                    <li><a href="tel:+375297034014">+375 (29) 703 40 14</a></li>
                </ul>
                <div class="rd-social">
                    <img src="{{ asset('/elitvid_assets/redesign/images/social-ig.svg') }}" alt="Instagram" width="24" height="24">
                    <img src="{{ asset('/elitvid_assets/redesign/images/social-vk.svg') }}" alt="ВКонтакте" width="24" height="24">
                    <img src="{{ asset('/elitvid_assets/redesign/images/social-fb.svg') }}" alt="Facebook" width="24" height="24">
                </div>
            </div>
        </div>
    </div>
</footer>
