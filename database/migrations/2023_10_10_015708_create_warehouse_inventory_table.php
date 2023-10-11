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
        Schema::create('warehouse_inventory', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('raw_material_id');
            $table->unsignedBigInteger('warehouse_id');
            $table->integer('quantity');
            $table->integer('reorder_level');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('raw_material_id')->references('id')->on('raw_materials');
            $table->foreign('warehouse_id')->references('id')->on('warehouse');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_inventory');
    }
};
