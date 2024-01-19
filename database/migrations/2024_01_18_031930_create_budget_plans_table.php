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
        Schema::create('budget_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userID'); 
            $table->unsignedBigInteger('categoryID'); 
            $table->string('name', 50); 
            $table->decimal('amount', 10, 2)->default(0);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('userID')->references('id')->on('users');
            $table->foreign('categoryID')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_plans');
    }
};
