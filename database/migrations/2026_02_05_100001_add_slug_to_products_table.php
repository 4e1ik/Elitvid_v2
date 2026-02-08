<?php

use App\Helpers\SlugGenerateHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('slug', 255)->nullable()->after('name');
        });

        $slugHelper = new SlugGenerateHelper();
        $products = DB::table('products')->get();
        foreach ($products as $product) {
            $slug = $slugHelper->slug((string) $product->name);
            if ($slug === '') {
                $slug = 'product-' . $product->id;
            }
            DB::table('products')->where('id', $product->id)->update(['slug' => $slug]);
        }

        DB::statement('ALTER TABLE products MODIFY slug VARCHAR(255) NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
