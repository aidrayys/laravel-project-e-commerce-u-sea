<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->bigInteger('subtotal')->nullable()->after('address');
            $table->bigInteger('shipping')->nullable()->after('subtotal');
            $table->bigInteger('discount_total')->nullable()->after('shipping');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'shipping', 'discount_total']);
        });
    }
};
