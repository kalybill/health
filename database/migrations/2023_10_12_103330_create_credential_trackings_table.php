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
        Schema::create('credential_trackings', function (Blueprint $table) {
            $table->id();
            $table->string('nurse_id')->nullable();
            $table->string('document_name')->nullable();
            $table->date('issue_date')->nullable();
            $table->string('expires')->nullable();
            $table->date('expiry_date')->nullable();
            $table->date('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credential_trackings');
    }
};
