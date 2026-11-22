@php
    $photo = fn (string $name) => asset("/elitvid_assets/redesign/images/{$name}.webp");
@endphp
<div class="rd-mosaic">
    <x-elitvid.direction-card :href="route('flowerbeds')" :image="$photo('beds')" label="Сборные клумбы" />
    <div class="rd-slogan">
        <img class="rd-slogan__star" src="{{ asset('/elitvid_assets/redesign/images/star.webp') }}" alt="" width="486" height="418" loading="lazy">
        <div class="rd-slogan__text">
        <p class="rd-slogan__title">Мы воплотим в реальность любую вашу идею!</p>
        <p>Мы предлагаем широкий спектр услуг, включая доставку во все Республики. Мы стремимся к долгосрочному сотрудничеству и готовы предложить индивидуальные условия и гибкую ценовую политику.</p>
        </div>
    </div>
    <x-elitvid.direction-card :href="route('pots')" :image="$photo('pots')" label="Кашпо" />
    <x-elitvid.direction-card :image="$photo('flowers')" label="Цветы" />
    <x-elitvid.direction-card :image="$photo('plants')" label="Растения" />
    <x-elitvid.direction-card :href="route('benches')" :image="$photo('benches')" label="Скамьи" />
    <x-elitvid.direction-card :href="route('static_page', ['slug' => 'kamennye-rotondy-kolonny'])" :image="$photo('rotunda')" label="Ротонды и колоннады" />
    <x-elitvid.direction-card :href="route('static_page', ['slug' => 'kamennye-navesy-i-parklety'])" :image="$photo('parklets')" label="Парклеты, навесы" />
    <x-elitvid.direction-card :href="route('static_page', ['slug' => 'stolby-i-nakryvki-iz-kamnya'])" :image="$photo('pillars')" label="Столбы и накрывки" />
    <x-elitvid.direction-card :image="$photo('gazebo')" label="Навесы и беседки" />
    <x-elitvid.direction-card :image="$photo('urns')" label="Урны" />
</div>
