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
        Schema::create('user_profiles', function (Blueprint $table) {            
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('image')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('phone_number'); // store as string
            $table->unsignedBigInteger('town_id'); // FK to towns table if exists
            $table->enum('gender', ['male', 'female', 'other']);
            $table->enum('status', ['pending', 'blacklisted', 'active'])->default('pending'); 
            $table->timestamps();
        }); 

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
