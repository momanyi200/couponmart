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
        Schema::create('businesses', function (Blueprint $table) {
            //$table->increments('id');
            $table->id(); 
            $table->string('business_name');
            $table->string('image')->nullable();
            $table->text('bios')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->double('town_id');
            $table->string('location')->nullable();
            $table->string('room')->nullable();
            $table->string('floor')->nullable();
            $table->string('building')->nullable();
            $table->double('phone_number')->nullable();
            $table->string('verified')->nullable();
            $table->enum(
                'status',
                ['pending','blacklisted','active']
            )->default('pending'); 
            $table->timestamps();  
            $table->softDeletes();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
