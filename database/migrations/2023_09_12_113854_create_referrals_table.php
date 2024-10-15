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
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('mrn', 200)->unique();
            $table->string('address', 200)->nullable();
            $table->date('ref_date')->nullable();
            $table->date('soc_date')->nullable();
            $table->bigInteger('access_type_id')->nullable();
            $table->bigInteger('pump_id')->nullable();
            $table->bigInteger('ref_source_type_id')->nullable();
            $table->string('ref_source_staff',200)->nullable();
            $table->bigInteger('status')->nullable();
            $table->text('reason')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender',['male', 'female'])->nullable();
            $table->enum('marital_status',['single', 'married','widowed','divorced','separated'])->nullable();
            $table->string('street_addr', 200)->nullable();
            $table->string('city', 200)->nullable();
            $table->string('state', 200)->nullable();
            $table->string('zip', 200)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('alt_phone', 50)->nullable();
            $table->string('language', 100)->nullable();
            $table->string('emerg_cont', 200)->nullable();
            $table->string('emerg_relation_to_patient', 100)->nullable();
            $table->string('emerg_phone', 50)->nullable();
            $table->text('allergies')->nullable();
            $table->string('remarks')->nullable();
            $table->string('est_delivery_time',100)->nullable();
            $table->string('staff_for_patient_recorde',100)->nullable();
            $table->bigInteger('booked_rn')->nullable();
            $table->bigInteger('potential_rn_1')->nullable();
            $table->bigInteger('potential_rn_2')->nullable();
            $table->bigInteger('potential_rn_3')->nullable();
            $table->string('md_order_1')->nullable();
            $table->string('md_order_2')->nullable();
            $table->string('md_order_3')->nullable();
            $table->bigInteger('staff')->nullable();
            $table->tinyInteger('is_new')->default('1');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
