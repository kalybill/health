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
        Schema::create('service_infos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patient_id')->nullable();
            $table->date('cert_from')->nullable();
            $table->date('discharge_date')->nullable();
            $table->string('duration',200)->nullable();
            $table->string('authorization',200)->nullable();
            $table->string('contracted_lab',200)->nullable();
            $table->tinyInteger('access_in_place')->default('0');
            $table->date('date_placed')->nullable();
            $table->bigInteger('alternate_rn')->nullable();
            $table->text('lab_orders')->nullable();
            $table->text('soc_report')->nullable();
            $table->text('pt_feedback_on_rn')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_infos');
    }
};
