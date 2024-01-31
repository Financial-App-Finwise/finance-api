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
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userID');
            $table->string('name', 50);
            $table->decimal('amount', 10, 2); 
            $table->decimal('currentSave', 10, 2)->nullable();
            $table->decimal('remainingSave', 10, 2)->nullable();
            $table->boolean('setDate')->default(true); // New field to store user's choice
            $table->date('startDate')->nullable();
            $table->date('endDate')->nullable();
            $table->decimal('monthlyContribution', 10, 2);
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
        Schema::dropIfExists('goals');
    }
};
