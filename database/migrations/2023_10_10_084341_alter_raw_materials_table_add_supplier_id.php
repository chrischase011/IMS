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
        Schema::table('raw_materials', function (Blueprint $table) {
            $table->unsignedBigInteger('supplier_id')->after('availability')->nullable();
            
            // Define a foreign key constraint to link the supplier_id with the suppliers table.
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('raw_materials', function (Blueprint $table) {
            // Drop the foreign key constraint and the supplier_id column if needed.
            $table->dropForeign(['supplier_id']);
            $table->dropColumn('supplier_id');
        });    
    }
};
