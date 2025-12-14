<?php

namespace Database\Seeders;

use App\Models\StaticPage;
use Illuminate\Database\Seeder;

class StaticPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'page' => 'bollards_and_fencing',
                'title' => 'Болларды <br> и ограждения <br> из камня',
                'description' => 'Обладают противотаранными свойствами поэтому идеально подходят для защиты зданий и площадей. Есть возможность нанести орнамент или логотип на ваше изделие. А также же разместить металлическую вставку.',
                'main_image' => '/elitvid_assets/newDesign/newDesign/imgs/bollards/main_bollards.png',
                'alt_image' => 'Болларды и ограждения',
            ],
            [
                'page' => 'facade_stucco_molding_and_panels',
                'title' => 'Фасадная лепнина <br> и панели из камня',
                'description' => 'Работаем по индивидуальным размерам, эскизам и чертежам, а также предоставляем Каталог готовых изделий',
                'main_image' => '/elitvid_assets/newDesign/newDesign/imgs/facades/facades.png',
                'alt_image' => 'Фасадная лепнина и панели',
            ],
            [
                'page' => 'parklets_and_canopies',
                'title' => 'Каменные <br> навесы <br> и парклеты',
                'description' => 'Работаем по индивидуальным размерам, эскизам и чертежам, а также предоставляем Каталог готовых изделий',
                'main_image' => '/elitvid_assets/newDesign/newDesign/imgs/parklets/parklets.png',
                'alt_image' => 'Парклеты и навесы',
            ],
            [
                'page' => 'pillars_and_covers',
                'title' => 'Столбы <br> и накрывки <br> из камня',
                'description' => 'Работаем по индивидуальным размерам, эскизам и чертежам, а также предоставляем Каталог готовых изделий',
                'main_image' => '/elitvid_assets/newDesign/newDesign/imgs/pillars/pillars.png',
                'alt_image' => 'Столбы и накрывки',
            ],
            [
                'page' => 'rotundas_and_colonnades',
                'title' => 'Каменные <br> ротонды <br> и колонны',
                'description' => 'Ротонда - это разновидность достаточно крупных и заметных малых архитектурных форм, которые служат местом для приятного времяпрепровождения. Всегда имеет круглую форму, колоннаду и купол. <br><br> Беседка – ротонда является эксклюзивных элементом оформления садов и парков. Дополнив её скамейками, Вы получаете место для комфортного отдыха.',
                'main_image' => '/elitvid_assets/newDesign/newDesign/imgs/rotundas/rotundas.png',
                'alt_image' => 'Ротонды и колонны',
            ],
            [
                'page' => 'small_architectural_forms',
                'title' => 'Малые <br> архитектурные <br> формы',
                'description' => 'Малые архитектурные формы (МАФ) - это элементы благоустройства и озеленения, которые дополняют и украшают пространство. К ним относятся скамейки, урны, вазоны, фонтаны, арки, перголы и другие декоративные элементы. <br><br> МАФ создают уютную атмосферу, зонируют пространство и делают его более функциональным и привлекательным.',
                'main_image' => '/elitvid_assets/newDesign/newDesign/imgs/maf/maf.png',
                'alt_image' => 'Малые архитектурные формы',
            ],
        ];

        foreach ($pages as $page) {
            StaticPage::updateOrCreate(
                ['page' => $page['page']],
                $page
            );
        }
    }
}
