<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            // Step 1: Add temporary column
            $table->unsignedBigInteger('business_id_new')->nullable()->after('title');
        });

        // Step 2: Copy data from old column to new (safe)
        DB::statement('UPDATE coupons SET business_id_new = business_id');

        Schema::table('coupons', function (Blueprint $table) {
            // Step 3: Drop old wrong column
            $table->dropColumn('business_id');

            // Step 4: Rename the new one
            $table->renameColumn('business_id_new', 'business_id');
        });

        Schema::table('coupons', function (Blueprint $table) {
            // Step 5: Add foreign key constraint
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
         Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('business_id');
        });
    }
};
