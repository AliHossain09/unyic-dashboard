<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('brand_id')->nullable()->after('brand');
            $table->foreign('brand_id')->references('id')->on('brands')->nullOnDelete();
        });

        if (Schema::hasTable('products') && Schema::hasTable('brands')) {
            $brands = DB::table('products')
                ->selectRaw('LOWER(TRIM(brand)) as name')
                ->whereNotNull('brand')
                ->where('brand', '<>', '')
                ->groupByRaw('LOWER(TRIM(brand))')
                ->get()
                ->pluck('name');

            foreach ($brands as $brandName) {
                $slug = Str::slug($brandName);
                DB::table('brands')->updateOrInsert(
                    ['slug' => $slug],
                    ['name' => $brandName, 'created_at' => now(), 'updated_at' => now()]
                );
            }

            $brandMap = DB::table('brands')->pluck('id', 'slug');

            foreach (DB::table('products')->whereNotNull('brand')->where('brand', '<>', '')->cursor() as $product) {
                $slug = Str::slug($product->brand);
                $brandId = $brandMap[$slug] ?? null;
                if ($brandId) {
                    DB::table('products')
                        ->where('id', $product->id)
                        ->update(['brand_id' => $brandId]);
                }
            }
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropColumn('brand_id');
        });
    }
};
