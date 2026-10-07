<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('original_price')->nullable()->after('price');
            $table->unsignedTinyInteger('discount_percentage')->nullable()->after('original_price');
            $table->boolean('is_promo')->default(false)->after('discount_percentage');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['original_price', 'discount_percentage', 'is_promo']);
        });
    }
};
