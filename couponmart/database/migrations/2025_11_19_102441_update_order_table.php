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
        //
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('redeemed_by')->nullable();
            $table->timestamp('redeemed_at')->nullable();
            $table->boolean('qr_active')->default(true);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
         Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
