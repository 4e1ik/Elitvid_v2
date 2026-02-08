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
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('slug', 255)->nullable()->after('title');
        });

        $slugHelper = new SlugGenerateHelper();
        $blogs = DB::table('blogs')->get();
        foreach ($blogs as $blog) {
            $slug = $slugHelper->slug((string) $blog->title);
            DB::table('blogs')->where('id', $blog->id)->update(['slug' => $slug]);
        }

        DB::statement('ALTER TABLE blogs MODIFY slug VARCHAR(255) NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
