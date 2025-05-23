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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            $table->uuid('uuid')->index();
            $table->string('code')->nullable();
            $table->string('numero_bon_commande')->nullable();
            $table->string('numero_serie')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();

            $table->string('marque_uuid')->nullable();
            $table->string('categorie_uuid')->nullable();
            $table->string('model_uuid')->nullable();
            $table->string('model_Materiel')->nullable();
            $table->string('famille_uuid')->nullable();
            $table->string('source_uuid')->nullable();
            $table->string('entrepot_uuid')->nullable();
            $table->enum('status', ['enFabrication', 'sortiUsine', 'enExpedition', 'arriverAuPod','received', 'stocked', 'expEnCours', 'delivered'])->default("enFabrication");

            $table->enum('familyGroup', ['JALO', 'NEEMBA CI','NEEMBA INTERNATIONAL'])->nullable();
            $table->string('num_billOfLading')->nullable();


            $table->date('date_Eta')->nullable();
            $table->date('date_reception')->nullable();
            $table->date('date_stockage')->nullable();
            $table->date('date_outStock')->nullable();

            $table->integer('poid_tonne')->nullable();
            $table->integer('hauteur')->nullable();
            $table->integer('largeur')->nullable();
            $table->integer('volume')->nullable();
            $table->integer('longueur')->nullable();
            $table->string('price_unitaire')->nullable();
            $table->string('price_dollars')->nullable();
            $table->string('price_euro')->nullable();
            $table->string('is_AddSourcing')->default('false');

            $table->string('etat')->default('actif');
            $table->timestamps();
        });
    }


    /**
     *

     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
