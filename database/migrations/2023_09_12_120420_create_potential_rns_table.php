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
        Schema::create('potential_rns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referral_id');
            $table->unsignedBigInteger('nurse_id');
            $table->timestamps();

            $table->foreign('referral_id')->references('id')->on('referrals')->constrained()->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('nurse_id')->references('id')->on('nurses')->constrained()->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('potential_rns');
    }
};
