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
            $table->unsignedBigInteger('parentID');
            $table->unsignedBigInteger('categoryID');
            $table->unsignedBigInteger('goalID')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('contributionAmount', 10, 2)->nullable(); 
            $table->date('date');
            $table->text('note')->nullable();
            $table->string('type', 10)->default('expense'); // Default option type to 'expense'
            $table->timestamps();

            // Foreign key constraints
            //$table->foreign('userID')->references('id')->on('users');
            $table->foreign('parentID')->references('id')->on('parent_categories')->onDelete('cascade');
            $table->foreign('categoryID')->references('id')->on('categories');
            $table->foreign('goalID')->references('id')->on('goals');
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
