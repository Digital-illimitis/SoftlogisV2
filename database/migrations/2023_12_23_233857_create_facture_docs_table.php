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
        Schema::create('facture_docs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->string('facture_uuid')->nullable();
            $table->string('file_path')->nullable();
            $table->string('facture_original')->nullable();
            $table->string('etat')->default('actif');
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facture_docs');
    }
};
