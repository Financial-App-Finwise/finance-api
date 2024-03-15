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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userID')->nullable();
            $table->string('name', 50);
            $table->tinyInteger('isIncome')->default(0); // Default type to 0 for expense and 1 for income
            $table->unsignedBigInteger('parentID')->nullable(); // Nullable parentID for child categories
            $table->tinyInteger('level'); // Level: 2 for parent categories, 1 for child categories
            $table->tinyInteger('isOnboarding')->default(0); // Default is0nboarding to 1 and 0 to normal categories
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('userID')->references('id')->on('users');
            $table->foreign('parentID')->references('id')->on('categories');
        });
    }
    


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
