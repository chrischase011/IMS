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
        Schema::table('stock_transaction', function(Blueprint $table){
            $table->unsignedBigInteger('warehouse_id')->nullable();

            $table->foreign('warehouse_id')->on('warehouse')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_transaction', function(Blueprint $table){
            $table->dropColumn('warehouse_id');
        });
    }
};
