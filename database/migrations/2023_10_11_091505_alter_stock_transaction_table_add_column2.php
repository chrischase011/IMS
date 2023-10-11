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
            $table->text('transaction_operation')->nullable()->after('transaction_type');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_transaction', function(Blueprint $table){
            $table->dropColumn('transaction_operation');

        });
    }
};
