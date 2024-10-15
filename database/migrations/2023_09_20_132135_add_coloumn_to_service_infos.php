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
        Schema::table('service_infos', function (Blueprint $table) {
            $table->integer('case_type_id')->nullable()->after('authorization');
            $table->integer('service_type_id')->nullable()->after('authorization');
            $table->text('diagnosis_1')->nullable()->after('authorization');
            $table->text('diagnosis_2')->nullable()->after('authorization');
            $table->text('diagnosis_3')->nullable()->after('authorization');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_infos', function (Blueprint $table) {
            
        });
    }
};
