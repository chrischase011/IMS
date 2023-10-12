<?php

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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('discount');

            $table->decimal('gross_amount', 10, 2);
            $table->decimal('vat', 10, 2);
            $table->text("shipping_address");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('shipping_address');
            $table->dropColumn('vat');
            $table->dropColumn('gross_amount');
            
            $table->decimal('discount', 10, 2);
        });
    }
};
