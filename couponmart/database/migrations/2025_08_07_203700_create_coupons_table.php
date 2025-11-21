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
        Schema::create('coupons', function (Blueprint $table) {
            
            //$table->increments('id');
            $table->id(); 
            $table->string('title');     
            $table->double('business_id');       
            $table->double('cost');
            $table->text('details');
            $table->date('start_date');
            $table->date('end_date');
            $table->double('total_vouchers');
            $table->double('remaining_vouchers');
            $table->string('image')->nullable();
            $table->double('total_view')->nullable();
            $table->enum(
                'status',
                ['pending','active','blacklisted','suspended','under review', 'expired','matured']
            )->default('pending');
            
            $table->double('system_charges')->nullable();
            $table->timestamps();
            $table->softDeletes();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
