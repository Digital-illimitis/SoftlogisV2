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
        Schema::create('facture_proformas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->string('transporteur_uuid')->nullable();
            $table->string('destination_uuid')->nullable();
            $table->string('porteChar_uuid')->nullable();
            $table->string('montant')->nullable();
            $table->string('etat')->default('actif');
            $table->string('code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facture_proformas');
    }
};
