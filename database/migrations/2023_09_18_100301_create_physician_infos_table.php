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
        Schema::create('physician_infos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patient_id')->nullable();
            $table->string('referring_md')->nullable();
            $table->string('npi')->nullable();
            $table->string('street_addr')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('alt_referring_md')->nullable();
            $table->string('alt_npi')->nullable();
            $table->string('alt_street_addr')->nullable();
            $table->string('alt_city')->nullable();
            $table->string('alt_state')->nullable();
            $table->string('alt_zip')->nullable();
            $table->string('alt_phone')->nullable();
            $table->string('alt_fax')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physician_infos');
    }
};
