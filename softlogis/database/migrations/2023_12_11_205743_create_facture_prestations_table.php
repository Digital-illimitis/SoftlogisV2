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
        Schema::create('facture_prestations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index()->unique();
            $table->string('etat')->default('actif');
            $table->string('facture_uuid')->nullable();
            //$table->string('prestation')->nullable();
            $table->string('type_prestation')->nullable();
            $table->integer('qty')->nullable();
            $table->string('description')->nullable();
            $table->integer('prixunitaire')->nullable();
            $table->string('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facture_prestations');
    }
};
