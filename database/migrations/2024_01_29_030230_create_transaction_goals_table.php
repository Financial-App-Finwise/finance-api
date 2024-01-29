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
        Schema::create('transaction_goals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userID');
            $table->unsignedBigInteger('transactionID');
            $table->unsignedBigInteger('goalID');
            $table->decimal('ContributionAmount', 10, 2);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('userID')->references('id')->on('users');
            $table->foreign('transactionID')->references('id')->on('transactions');
            $table->foreign('goalID')->references('id')->on('goals');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_goals');
    }
};
