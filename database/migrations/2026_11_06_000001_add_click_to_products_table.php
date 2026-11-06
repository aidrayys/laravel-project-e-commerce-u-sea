<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add the `click` column required by the product click-tracking dashboard task.
     * Kept defensive: does nothing if the column already exists, and backfills from
     * legacy `clicks` data when present.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('products', 'click')) {
            Schema::table('products', function (Blueprint $table) {
                // Integer with default 0 and non-negative values (unsigned).
                $after = Schema::hasColumn('products', 'clicks') ? 'clicks' : 'rating';
                $table->unsignedInteger('click')->default(0)->after($after)->comment('Total product detail page views');
            });

            if (Schema::hasColumn('products', 'clicks')) {
                DB::table('products')
                    ->where(function ($query) {
                        $query->whereNull('click')->orWhere('click', 0);
                    })
                    ->where('clicks', '>', 0)
                    ->update(['click' => DB::raw('clicks')]);
            }
        }

        // Ensure every existing product has an initial click value of 0.
        DB::table('products')->whereNull('click')->update(['click' => 0]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('products', 'click')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('click');
            });
        }
    }
};
