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
        Schema::create('prestation_lines', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->string('facture_uuid')->nullable();
            $table->string('etat')->nullable();
            $table->string('rubrique')->nullable();
            $table->integer('prixUnitaire')->default(0)->nullable();
            $table->integer('qty')->default(0)->nullable();
            $table->integer('totalLigne')->default(0)->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestation_lines');
    }
};
