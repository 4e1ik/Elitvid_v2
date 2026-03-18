<?php

namespace App\Console\Commands;

use App\Helpers\SlugGenerateHelper;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BackfillProductSlugs extends Command
{
    protected $signature = 'products:backfill-slugs {--dry-run : Только показать изменения, не записывать в БД}';
    protected $description = 'Создаёт slug только для товаров, у которых slug пустой';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $slugHelper = new SlugGenerateHelper();

        $query = Product::query()
            ->whereNull('slug')
            ->orWhere('slug', '');

        $total = (clone $query)->count();

        if ($total === 0) {
            $this->info('Нет товаров без slug. Ничего делать не нужно.');
            return self::SUCCESS;
        }

        $this->info("Найдено товаров без slug: {$total}");
        if ($dryRun) {
            $this->warn('DRY RUN: изменения не будут записаны в БД.');
        }

        $updated = 0;

        DB::transaction(function () use ($query, $slugHelper, $dryRun, &$updated) {
            $query->orderBy('id')->chunkById(200, function ($products) use ($slugHelper, $dryRun, &$updated) {
                foreach ($products as $product) {
                    $base = $slugHelper->slug((string) $product->name);

                    if ($base === '') {
                        $base = 'product-' . $product->id;
                    }

                    $slug = $base;
                    $i = 2;

                    // Уникальность: если slug уже занят другим товаром — добавляем суффикс -2, -3, ...
                    while (
                    Product::where('slug', $slug)
                        ->where('id', '!=', $product->id)
                        ->exists()
                    ) {
                        $slug = $base . '-' . $i;
                        $i++;
                    }

                    $this->line("ID {$product->id}: \"{$product->name}\" -> {$slug}");

                    if (!$dryRun) {
                        $product->update(['slug' => $slug]);
                    }

                    $updated++;
                }
            });
        });

        $this->info("Готово. Обработано: {$updated}");
        return self::SUCCESS;
    }
}
