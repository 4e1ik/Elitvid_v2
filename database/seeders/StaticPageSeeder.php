<?php

namespace Database\Seeders;

use App\Models\StaticPage;
use App\Models\MetaTag;
use App\Services\ImageService;
use Illuminate\Database\Seeder;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class StaticPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Направления, которые имеют отдельные страницы и плитки в блоке "Каталог изделий"
         * slug совпадает с текущим page в контроллерах и метатегах
         */
        $pages = [
            'facade_stucco_molding_and_panels' => [
                'title' => 'Фасадная лепнина <br> и панели из камня',
                'subtitle' => 'Работаем по индивидуальным размерам, эскизам и чертежам, а также предоставляем Каталог готовых изделий',
                'menu_name' => 'Фасадная лепнина и панели',
                'hero_image' => '/elitvid_assets/newDesign/newDesign/imgs/facades/facades.webp',
                'menu_image' => '/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/facade_stucco.webp',
            ],
            'parklets_and_canopies' => [
                'title' => 'Каменные <br> навесы <br> и парклеты',
                'subtitle' => 'Работаем по индивидуальным размерам, эскизам и чертежам, а также предоставляем Каталог готовых изделий',
                'menu_name' => 'Парклеты и навесы',
                'hero_image' => '/elitvid_assets/newDesign/newDesign/imgs/parklets/parklets.webp',
                'menu_image' => '/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/parklets.webp',
            ],
            'pillars_and_covers' => [
                'title' => 'Столбы <br> и накрывки <br> из камня',
                'subtitle' => 'Работаем по индивидуальным размерам, эскизам и чертежам, а также предоставляем Каталог готовых изделий',
                'menu_name' => 'Столбы и накрывки',
                'hero_image' => '/elitvid_assets/newDesign/newDesign/imgs/pillars/pillars.webp',
                'menu_image' => '/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/pillars.webp',
            ],
            'rotundas_and_colonnades' => [
                'title' => 'Каменные <br> ротонды <br> и колонны',
                'subtitle' => 'Ротонда - это разновидность достаточно крупных и заметных малых архитектурных форм, которые служат местом для приятного времяпрепровождения. Всегда имеет круглую форму, колоннаду и купол. <br><br> Беседка – ротонда является эксклюзивных элементом оформления садов и парков. Дополнив её скамейками, Вы получаете место для комфортного отдыха.',
                'menu_name' => 'Ротонды и колонны',
                'hero_image' => '/elitvid_assets/newDesign/newDesign/imgs/rotundas/rotundas.webp',
                'menu_image' => '/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/rotundas.webp',
            ],
            'small_architectural_forms' => [
                'title' => 'Малые <br> архитектурные <br> формы',
                'subtitle' => 'Малые архитектурные формы (МАФ) - это элементы благоустройства и озеленения, которые дополняют и украшают пространство. К ним относятся скамейки, урны, вазоны, фонтаны, арки, перголы и другие декоративные элементы. <br><br> МАФ создают уютную атмосферу, зонируют пространство и делают его более функциональным и привлекательным.',
                'menu_name' => 'Малые архитектурные формы',
                'hero_image' => '/elitvid_assets/newDesign/newDesign/imgs/maf/maf.webp',
                'menu_image' => '/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/1maf.webp',
            ],
            'concrete_products' => [
                'title' => 'Изделия из <br> бетона',
                'subtitle' => 'Описание изделий из бетона',
                'menu_name' => 'Изделия из бетона',
                'hero_image' => '/elitvid_assets/newDesign/newDesign/imgs/concrete_products/concrete_products1.webp',
                'menu_image' => '/elitvid_assets/newDesign/newDesign/imgs/main_page/directions/concrete_products1.webp',
            ],
        ];

        foreach ($pages as $slug => $config) {
            // Берем мета-теги, если есть
            $meta = MetaTag::where('page', $slug)->first();

            $staticPage = StaticPage::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $config['title'],
                    'subtitle' => $config['subtitle'],
                    // пока кладем основной текст таким же, как подзаголовок
                    'content' => $config['subtitle'],
                    'menu_name' => $config['menu_name'],
                    'meta_title' => $meta->title ?? $config['menu_name'],
                    'meta_description' => $meta->description ?? strip_tags($config['subtitle']),
                    'active' => true,
                ]
            );

            // Чистим старые привязанные главные/меню-картинки для этой страницы,
            // чтобы не плодить дубли при повторном запуске сидера
            $staticPage->images()
                ->where(function ($q) {
                    $q->where('main_image', 1)->orWhere('menu_image', 1);
                })
                ->delete();

            /** @var ImageService $imageService */
            $imageService = app(ImageService::class);

            // Hero-картинка (главная) — сохраняем так, как будто её загрузили вручную
            if (!empty($config['hero_image'])) {
                $heroPath = public_path(ltrim($config['hero_image'], '/'));

                if (is_file($heroPath)) {
                    $uploadedHero = new UploadedFile(
                        $heroPath,
                        basename($heroPath),
                        null,
                        null,
                        true // test mode, чтобы миновать is_uploaded_file
                    );

                    $imageService->save(
                        images: [$uploadedHero],
                        model: $staticPage,
                        imageData: [[
                            'main_image' => true,
                            'menu_image' => false,
                            'description_image' => null,
                        ]]
                    );
                }
            }

            // Картинка для плитки в меню направлений
            if (!empty($config['menu_image'])) {
                $menuPath = public_path(ltrim($config['menu_image'], '/'));

                if (is_file($menuPath)) {
                    $uploadedMenu = new UploadedFile(
                        $menuPath,
                        basename($menuPath),
                        null,
                        null,
                        true
                    );

                    $imageService->save(
                        images: [$uploadedMenu],
                        model: $staticPage,
                        imageData: [[
                            'main_image' => false,
                            'menu_image' => true,
                            'description_image' => null,
                        ]]
                    );
                }
            }
        }
    }
}
