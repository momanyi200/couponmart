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
        Schema::create('system_charges', function (Blueprint $table) {
            $table->id();

            // category
            $table->foreignId('cat_id')
                ->constrained('categories')
                ->cascadeOnDelete();

            // percentage that system keeps
            $table->decimal('percentage', 5, 2); // e.g. 5.50%

            // who added it
            $table->foreignId('added_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_charges');
    }
};
