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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->string('logo')->nullable();
            $table->string('code')->nullable();
            // $table->string('type')->nullable();
            $table->enum('type', ['client', 'transitaire', 'transporteur', 'organisation'])->nullable();
            $table->string('identification')->nullable();
            $table->string('raison_sociale')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('localisation')->nullable();
            $table->longText('description')->nullable();
            $table->string('voie_transport', 20)->nullable();

            $table->string('contact_one_name')->nullable();
            $table->string('contact_one_lastName')->nullable();
            $table->string('contact_one_email')->nullable();
            $table->string('contact_two_name')->nullable();
            $table->string('contact_two_lastName')->nullable();
            $table->string('contact_two_email')->nullable();

            $table->string('isActive')->default('true');

            $table->string('etat')->default('actif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
