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
        Schema::create('md_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referral_id');
            $table->string('order_description');
            $table->timestamps();

            $table->foreign('referral_id')->references('id')->on('referrals')->constrained()->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('md_orders');
    }
};
