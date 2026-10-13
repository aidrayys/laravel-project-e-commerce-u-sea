<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create categories from existing product category strings and link them.
        Product::select('category')->distinct()->pluck('category')->each(function (string $name) {
            $category = Category::firstOrCreate(['name' => $name]);

            Product::where('category', $name)
                ->whereNull('category_id')
                ->update(['category_id' => $category->id]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Product::query()->update(['category_id' => null]);
    }
};
