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
        Schema::table('orders', function(Blueprint $table){
            $table->unsignedBigInteger('customer_id')->nullable()->change();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function(Blueprint $table){
            $table->dropColumn('customer_name');
            $table->dropColumn('customer_email');
            $table->dropColumn('customer_phone');
            $table->unsignedBigInteger('customer_id')->nullable(false)->change();
        });
    }
};
