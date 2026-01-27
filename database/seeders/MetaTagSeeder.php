<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetaTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $metaTags = [
            [
                'page' => 'main',
                'title' => 'Изделия из полистоуна от производителя на заказ - Elitvid.com',
                'description' => 'Качественные изделия из полистоуна от производителя Elitvid.com. В нашем каталоге широкий выбор декоративных элементов для интерьера и экстерьера. Надежность, эстетика и доступные цены – только у нас!',
            ],
            [
                'page' => 'directions',
                'title' => 'Направления - Elitvid.com',
                'description' => 'Ознакомьтесь с нашими направлениями производства изделий из полистоуна. Широкий ассортимент продукции для интерьера и экстерьера.',
            ],
            [
                'page' => 'decorations',
                'title' => 'Декоративные элементы из полистоуна - Elitvid.com',
                'description' => 'Декоративные элементы из полистоуна для украшения интерьера и экстерьера. Высокое качество и доступные цены.',
            ],
            [
                'page' => 'blog',
                'title' => 'Блог - Elitvid.com',
                'description' => 'Полезные статьи и новости о изделиях из полистоуна, дизайне интерьера и экстерьера.',
            ],
            [
                'page' => 'benches',
                'title' => 'Скамейки из полистоуна - Elitvid.com',
                'description' => 'Качественные скамейки из полистоуна для сада, парка и улицы. Различные коллекции и дизайны на любой вкус.',
            ],
            [
                'page' => 'pots',
                'title' => 'Кашпо из полистоуна - Elitvid.com',
                'description' => 'Стильные кашпо из полистоуна для дома и сада. Различные формы и размеры. Высокое качество и долговечность.',
            ],
            [
                'page' => 'bollards_and_fencing',
                'title' => 'Болларды и ограждения из полистоуна - Elitvid.com',
                'description' => 'Болларды и ограждения из полистоуна для благоустройства территории. Прочность, надежность и эстетичный внешний вид.',
            ],
            [
                'page' => 'verona_benches',
                'title' => 'Коллекция Verona - Скамейки из полистоуна - Elitvid.com',
                'description' => 'Скамейки коллекции Verona из полистоуна. Классический дизайн и высокое качество для вашего сада или парка.',
            ],
            [
                'page' => 'street_furniture_benches',
                'title' => 'Коллекция Уличная фурнитура - Скамейки - Elitvid.com',
                'description' => 'Скамейки коллекции Уличная фурнитура из полистоуна. Современный дизайн для городских пространств.',
            ],
            [
                'page' => 'solo_benches',
                'title' => 'Коллекция Solo - Скамейки из полистоуна - Elitvid.com',
                'description' => 'Скамейки коллекции Solo из полистоуна. Минималистичный дизайн и комфорт.',
            ],
            [
                'page' => 'lines_benches',
                'title' => 'Коллекция Lines - Скамейки из полистоуна - Elitvid.com',
                'description' => 'Скамейки коллекции Lines из полистоуна. Геометрические формы и современный стиль.',
            ],
            [
                'page' => 'stones_benches',
                'title' => 'Коллекция Stones - Скамейки из полистоуна - Elitvid.com',
                'description' => 'Скамейки коллекции Stones из полистоуна. Естественный вид камня и прочность полистоуна.',
            ],
            [
                'page' => 'rectangular_pots',
                'title' => 'Прямоугольные кашпо из полистоуна - Elitvid.com',
                'description' => 'Прямоугольные кашпо из полистоуна различных размеров. Идеально подходят для современных интерьеров и садов.',
            ],
            [
                'page' => 'square_pots',
                'title' => 'Квадратные кашпо из полистоуна - Elitvid.com',
                'description' => 'Квадратные кашпо из полистоуна. Геометрические формы для современного дизайна.',
            ],
            [
                'page' => 'round_pots',
                'title' => 'Круглые кашпо из полистоуна - Elitvid.com',
                'description' => 'Круглые кашпо из полистоуна различных диаметров. Классические формы для любого интерьера.',
            ],
        ];

        // Добавляем временные метки
        $metaTags = array_map(function ($metaTag) {
            return array_merge($metaTag, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }, $metaTags);

        // Используем insertOrIgnore чтобы не создавать дубликаты
        foreach ($metaTags as $metaTag) {
            DB::table('meta_tags')->updateOrInsert(
                ['page' => $metaTag['page']],
                $metaTag
            );
        }
    }
}
