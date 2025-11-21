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
          Schema::create('onboarding_steps', function (Blueprint $table) {
            $table->id();

            // Polymorphic relation: onboarding can be for any model (User, Customer, Vendor, etc.)
            $table->morphs('onboardable'); // creates onboardable_id & onboardable_type

            $table->string('step_name'); // e.g., "Account Setup", "Document Upload"
            $table->unsignedInteger('step_order')->nullable(); // e.g., 1, 2, 3...
            $table->enum('status', ['pending', 'in_progress', 'completed'])
                  ->default('pending');

            $table->json('metadata')->nullable(); // optional: store extra info for this step

            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onboarding_steps');
    }
};
