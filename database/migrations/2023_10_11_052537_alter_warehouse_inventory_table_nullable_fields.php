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
        Schema::table('warehouse_inventory', function(Blueprint $table){
            $table->unsignedBigInteger('product_id')->nullable()->change();
            $table->unsignedBigInteger('raw_material_id')->nullable()->change();
            $table->string('operation')->nullable()->change();
            $table->text('operation_details')->nullable()->change();
            $table->integer('reorder_level')->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
