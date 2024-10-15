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
        Schema::create('onboardings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->string('ref_info', 5)->nullable();
            $table->string('rx_order',5)->nullable();
            $table->string('loa_received',5)->nullable();
            $table->string('loa_extracted',5)->nullable();
            $table->string('date_entry',5)->nullable();
            $table->string('lab_form',5)->nullable();
            $table->string('order_emailed',5)->nullable();
            $table->string('rn_informed',5)->nullable();
            $table->string('lab_form_emailed',5)->nullable();
            $table->string('pt_contracted',5)->nullable();
            $table->string('pt_welcome',5)->nullable();
            $table->string('addr_correct',5)->nullable();
            $table->string('phone_number_reliable',5)->nullable();
            $table->string('get_access_code',200)->nullable();
            $table->string('nurse_park',200)->nullable();
            $table->string('pt_teach_train',5)->nullable();
            $table->unsignedBigInteger('staffer')->nullable();
            $table->string('remarks', 200)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onboardings');
    }
};
