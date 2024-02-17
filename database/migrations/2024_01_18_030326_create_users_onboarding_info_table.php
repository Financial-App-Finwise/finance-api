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
        Schema::create('users_onboarding_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userID')->nullable();
            $table->string('gender')->nullable();
            $table->integer('age')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('life_stage')->nullable();
            $table->decimal('daily_expense', 10, 2)->nullable();
            $table->decimal('weekly_expense', 10, 2)->nullable();
            $table->decimal('monthly_expense', 10, 2)->nullable();
            $table->decimal('daily_income', 10, 2)->nullable();
            $table->decimal('weekly_income', 10, 2)->nullable();
            $table->decimal('monthly_income', 10, 2)->nullable();
            $table->string('financial_goal', 100)->nullable();
            $table->decimal('dream_amount', 10, 2)->nullable();
            $table->date('envision_date')->nullable();
        
            $table->timestamps();
        
            // Foreign key constraint
            $table->foreign('userID')->references('id')->on('users');
        });
         
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_onboarding_info');
    }
};
