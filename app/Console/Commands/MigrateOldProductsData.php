<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateOldProductsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:old-products-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from pot_products, pot_images, bench_products, bench_images to new tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting data migration...');

        DB::beginTransaction();

        try {
            // Миграция pot_products
            $this->info('Migrating pot_products...');
            $potProductMapping = $this->migratePotProducts();

            // Миграция pot_images
            $this->info('Migrating pot_images...');
            $this->migratePotImages($potProductMapping);

            // Миграция bench_products
            $this->info('Migrating bench_products...');
            $benchProductMapping = $this->migrateBenchProducts();

            // Миграция bench_images
            $this->info('Migrating bench_images...');
            $this->migrateBenchImages($benchProductMapping);

            DB::commit();
            $this->info('Migration completed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Migration failed: ' . $e->getMessage());
            $this->error($e->getTraceAsString());
            return 1;
        }

        return 0;
    }

    /**
     * Миграция pot_products в products и pots
     * 
     * @return array Маппинг старых ID на новые (old_id => new_product_id)
     */
    private function migratePotProducts(): array
    {
        $mapping = [];
        $oldProducts = DB::table('pot_products')->get();

        foreach ($oldProducts as $oldProduct) {
            // Создаем запись в products
            $newProductId = DB::table('products')->insertGetId([
                'name' => $oldProduct->name,
                'product_type' => 'pot',
                'active' => $oldProduct->active ?? true,
                'meta_title' => $oldProduct->meta_title ?? null,
                'meta_description' => $oldProduct->meta_description ?? null,
                'created_at' => $oldProduct->created_at,
                'updated_at' => $oldProduct->updated_at,
                'deleted_at' => $oldProduct->deleted_at ?? null,
            ]);

            // Формируем data из size, weight, price в формате массива объектов
            // Старые данные хранятся как строки с разделителем "|": "40x40x40 | 50x50x50 | 60x60x60"
            // Формат результата: [{"size":"40x40x40","weight":"14 кг","price":"483,00 BYN"}, {...}]
            $data = [];
            
            // Разбиваем значения по разделителю "|" и очищаем от пробелов
            $sizes = !empty($oldProduct->size) 
                ? array_map('trim', explode('|', $oldProduct->size)) 
                : [];
            $weights = !empty($oldProduct->weight) 
                ? array_map('trim', explode('|', $oldProduct->weight)) 
                : [];
            $prices = !empty($oldProduct->price) 
                ? array_map('trim', explode('|', $oldProduct->price)) 
                : [];
            
            // Определяем максимальное количество вариантов
            $maxVariants = max(count($sizes), count($weights), count($prices));
            
            // Создаем объекты для каждого варианта
            for ($i = 0; $i < $maxVariants; $i++) {
                $variant = [];
                
                if (isset($sizes[$i]) && !empty($sizes[$i])) {
                    $variant['size'] = $sizes[$i];
                }
                if (isset($weights[$i]) && !empty($weights[$i])) {
                    $variant['weight'] = $weights[$i];
                }
                if (isset($prices[$i]) && !empty($prices[$i])) {
                    $variant['price'] = $prices[$i];
                }
                
                // Добавляем вариант только если есть хотя бы одно поле
                if (!empty($variant)) {
                    $data[] = $variant;
                }
            }

            // Создаем запись в pots
            DB::table('pots')->insert([
                'product_id' => $newProductId,
                'material' => $oldProduct->material ?? null,
                'collection' => $oldProduct->collection ?? null,
                'data' => !empty($data) ? json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : null,
                'created_at' => $oldProduct->created_at,
                'updated_at' => $oldProduct->updated_at,
            ]);

            $mapping[$oldProduct->id] = $newProductId;
        }

        $this->info("Migrated " . count($mapping) . " pot products");
        return $mapping;
    }

    /**
     * Миграция pot_images в images
     * 
     * @param array $productMapping Маппинг старых pot_product_id на новые product_id
     */
    private function migratePotImages(array $productMapping): void
    {
        $oldImages = DB::table('pot_images')->get();
        $count = 0;

        foreach ($oldImages as $oldImage) {
            if (!isset($productMapping[$oldImage->pot_product_id])) {
                $this->warn("Pot product ID {$oldImage->pot_product_id} not found in mapping, skipping image");
                continue;
            }

            DB::table('images')->insert([
                'imageable_id' => $productMapping[$oldImage->pot_product_id],
                'imageable_type' => 'App\Models\Product',
                'image' => $oldImage->image,
                'description_image' => $oldImage->description_image ?? null,
                'color' => $oldImage->color ?? null,
                'texture' => $oldImage->texture ?? null,
                'main_image' => false,
                'menu_image' => false,
                'created_at' => $oldImage->created_at,
                'updated_at' => $oldImage->updated_at,
            ]);

            $count++;
        }

        $this->info("Migrated {$count} pot images");
    }

    /**
     * Миграция bench_products в products и benches
     * 
     * @return array Маппинг старых ID на новые (old_id => new_product_id)
     */
    private function migrateBenchProducts(): array
    {
        $mapping = [];
        $oldProducts = DB::table('bench_products')->get();

        foreach ($oldProducts as $oldProduct) {
            // Создаем запись в products
            $newProductId = DB::table('products')->insertGetId([
                'name' => $oldProduct->name,
                'product_type' => 'bench',
                'active' => $oldProduct->active ?? true,
                'meta_title' => $oldProduct->meta_title ?? null,
                'meta_description' => $oldProduct->meta_description ?? null,
                'created_at' => $oldProduct->created_at,
                'updated_at' => $oldProduct->updated_at,
                'deleted_at' => $oldProduct->deleted_at ?? null,
            ]);

            // Формируем data из size, weight, price в формате массива объектов
            // Старые данные хранятся как строки с разделителем "|": "40x40x40 | 50x50x50 | 60x60x60"
            // Формат результата: [{"size":"40x40x40","weight":"14 кг","price":"483,00 BYN"}, {...}]
            $data = [];
            
            // Разбиваем значения по разделителю "|" и очищаем от пробелов
            $sizes = !empty($oldProduct->size) 
                ? array_map('trim', explode('|', $oldProduct->size)) 
                : [];
            $weights = !empty($oldProduct->weight) 
                ? array_map('trim', explode('|', $oldProduct->weight)) 
                : [];
            $prices = !empty($oldProduct->price) 
                ? array_map('trim', explode('|', $oldProduct->price)) 
                : [];
            
            // Определяем максимальное количество вариантов
            $maxVariants = max(count($sizes), count($weights), count($prices));
            
            // Создаем объекты для каждого варианта
            for ($i = 0; $i < $maxVariants; $i++) {
                $variant = [];
                
                if (isset($sizes[$i]) && !empty($sizes[$i])) {
                    $variant['size'] = $sizes[$i];
                }
                if (isset($weights[$i]) && !empty($weights[$i])) {
                    $variant['weight'] = $weights[$i];
                }
                if (isset($prices[$i]) && !empty($prices[$i])) {
                    $variant['price'] = $prices[$i];
                }
                
                // Добавляем вариант только если есть хотя бы одно поле
                if (!empty($variant)) {
                    $data[] = $variant;
                }
            }

            // Создаем запись в benches
            DB::table('benches')->insert([
                'product_id' => $newProductId,
                'material' => $oldProduct->material ?? null,
                'collection' => $oldProduct->collection ?? null,
                'data' => !empty($data) ? json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : null,
                'created_at' => $oldProduct->created_at,
                'updated_at' => $oldProduct->updated_at,
            ]);

            $mapping[$oldProduct->id] = $newProductId;
        }

        $this->info("Migrated " . count($mapping) . " bench products");
        return $mapping;
    }

    /**
     * Миграция bench_images в images
     * 
     * @param array $productMapping Маппинг старых bench_product_id на новые product_id
     */
    private function migrateBenchImages(array $productMapping): void
    {
        $oldImages = DB::table('bench_images')->get();
        $count = 0;

        foreach ($oldImages as $oldImage) {
            if (!isset($productMapping[$oldImage->bench_product_id])) {
                $this->warn("Bench product ID {$oldImage->bench_product_id} not found in mapping, skipping image");
                continue;
            }

            DB::table('images')->insert([
                'imageable_id' => $productMapping[$oldImage->bench_product_id],
                'imageable_type' => 'App\Models\Product',
                'image' => $oldImage->image,
                'description_image' => $oldImage->description_image ?? null,
                'color' => null, // bench_images не имеют color
                'texture' => null, // bench_images не имеют texture
                'main_image' => false,
                'menu_image' => false,
                'created_at' => $oldImage->created_at,
                'updated_at' => $oldImage->updated_at,
            ]);

            $count++;
        }

        $this->info("Migrated {$count} bench images");
    }
}
