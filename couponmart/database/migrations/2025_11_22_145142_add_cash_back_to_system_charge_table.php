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
        Schema::table('system_charges', function (Blueprint $table) {
            //
            $table->decimal('cashback_percentage', 5, 2)->default(0)->after('percentage'); 


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('system_charge', function (Blueprint $table) {
            //
        });
    }
};
