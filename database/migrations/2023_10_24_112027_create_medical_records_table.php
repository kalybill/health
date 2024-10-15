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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scheduling_id')->nullable();
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->time('total_time')->nullable();
            $table->date('date_process')->nullable();
            $table->string('spec_rate')->nullable();
            $table->string('route_sheet')->nullable();
            $table->string('note')->nullable();
            $table->text('missing_item')->nullable();
            $table->text('remarks')->nullable();
            $table->string('send_to_bill')->nullable();
            $table->unsignedDouble('bill_rate')->nullable();
            $table->string('billed')->nullable();
            $table->date('bill_date')->nullable();
            $table->string('paid')->nullable();
            $table->date('pay_date')->nullable();
            $table->text('billing_remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
