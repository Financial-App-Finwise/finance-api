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
            $table->string('name');
            $table->decimal('amount', 10, 2); 
            $table->float('currentSave')->nullable();
            $table->float('remainingSave')->nullable();
            $table->boolean('setDates')->default(true); // New field to store user's choice
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
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
