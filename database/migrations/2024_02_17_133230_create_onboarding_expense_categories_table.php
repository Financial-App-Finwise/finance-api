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
        Schema::create('onboarding_expense_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('onboardingID');
            $table->unsignedBigInteger('categoryID')->nullable();
            $table->unsignedBigInteger('parentID')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('onboardingID')->references('id')->on('users_onboarding_info');
            $table->foreign('categoryID')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onboarding_expense_category');
    }
};
