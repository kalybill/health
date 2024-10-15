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
        Schema::table('nurses', function (Blueprint $table) {
            $table->string('company_name',200)->nullable();
            $table->string('alt_phone',200)->nullable();
            $table->string('address',200)->nullable();
            $table->string('work_phone',200)->nullable();
            $table->string('city',200)->nullable();
            $table->string('state',200)->nullable();
            $table->string('zip',200)->nullable();
            $table->string('dob',200)->nullable();
            $table->string('status',200)->nullable();
            $table->string('discipline',200)->nullable();
            $table->string('specialty',200)->nullable();
            $table->string('education',200)->nullable();
            $table->string('current_job',200)->nullable();
            $table->string('current_shift',200)->nullable();
            $table->string('coverage_area',200)->nullable();
            $table->string('recruiter',200)->nullable();
            $table->string('recruiter_src',200)->nullable();
            $table->text('remark')->nullable();
            $table->date('application_date')->nullable();
            $table->date('rn_contracted')->nullable();
            $table->date('prescreen_interview')->nullable();
            $table->date('application')->nullable();
            $table->date('all_documents_submitted')->nullable();
            $table->date('background_check_completed')->nullable();
            $table->date('ref_check_completed')->nullable();
            $table->date('orientation')->nullable();
            $table->date('contract_signed')->nullable();
            $table->date('shadowed')->nullable();
            $table->date('first_visit')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nurses', function (Blueprint $table) {
            //
        });
    }
};
