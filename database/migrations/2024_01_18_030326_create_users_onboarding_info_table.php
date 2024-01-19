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
            $table->unsignedBigInteger('userID');
            $table->string('gender', 50);
            $table->string('motivation', 50);
            $table->string('financial_level', 50);
            $table->string('financial_target', 50);
            $table->string('target_duration', 50);
            $table->boolean('know_how_to_save');
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
