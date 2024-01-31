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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userID');
            $table->unsignedBigInteger('categoryID');
            $table->tinyInteger('isIncome')->default(0); // Default type to 0 for expense and 1 for income
            $table->decimal('amount', 10, 2)->default(0);
            $table->tinyInteger('hasContributed')->default(0); // Default to 0 for has contributed to goal and 1 for hasn't.
            $table->unsignedBigInteger('upcomingbillID')->nullable();
            $table->unsignedBigInteger('budgetplanID')->nullable();
            $table->enum('expenseType', ['General', 'Upcoming Bill', 'Budget Plan'])->default('General');
            $table->dateTime('date');
            $table->text('note')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('userID')->references('id')->on('users');
            $table->foreign('categoryID')->references('id')->on('categories');
            $table->foreign('upcomingbillID')->references('id')->on('upcoming_bills');
            $table->foreign('budgetplanID')->references('id')->on('budget_plans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
