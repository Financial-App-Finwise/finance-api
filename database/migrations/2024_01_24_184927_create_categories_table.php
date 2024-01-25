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
            $table->unsignedBigInteger('userID');
            $table->string('name', 50);
            $table->string('type', 10)->default('expense'); // Default option type to 'expense'
            //$table->string('user_defined_name')->nullable(); // Nullable for preset categories
            $table->unsignedBigInteger('parentID')->nullable();
            $table->timestamps();
             // Foreign key constraints
             $table->foreign('userID')->references('id')->on('users');
            // Foreign key constraint for parent category
            $table->foreign('parentID')->references('id')->on('parent_categories')->onDelete('cascade');
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
