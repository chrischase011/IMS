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
            $table->string('label')->after('id');
            $table->string('status')->after('quantity');
            $table->string('operation')->after('status');
            $table->text('operation_details')->after('operation');
            $table->unsignedBigInteger('supplier_id')->nullable()->after('warehouse_id');
            $table->unsignedBigInteger('user_id')->nullable()->after('raw_material_id');

            $table->foreign('supplier_id')->on('suppliers')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warehouse_inventory', function(Blueprint $table){
            $table->dropColumn('label');
            $table->dropColumn('status');
            $table->dropColumn('operation');
            $table->dropColumn('operation_details');
            $table->dropColumn('supplier_id');
            $table->dropColumn('user_id');
        });
    }
};
