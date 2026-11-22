@props(['file'])

<a class="rd-btn rd-btn--outline" href="{{ asset($file) }}" download>
    <img src="{{ asset('/elitvid_assets/redesign/images/download.svg') }}" alt="" width="24" height="24">
    <span>Скачать каталог</span>
</a>
