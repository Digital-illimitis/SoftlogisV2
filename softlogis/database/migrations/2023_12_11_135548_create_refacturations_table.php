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
        Schema::create('refacturations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index()->unique();
            $table->string('code');
            $table->string('etat')->default('actif');
            $table->enum('statut', ['draft', 'sendToClient', 'payed', 'canceled'])->nullable()->default('draft');
            $table->string('refClient')->nullable();
            $table->string('doit')->nullable();
            $table->string('adresseComplete')->nullable();
            $table->string('num_cc')->nullable();
            $table->string('pol')->nullable();
            $table->string('pod')->nullable();
            $table->string('regime')->nullable();
            $table->string('email')->nullable();
            $table->string('designation')->nullable();
            $table->string('num_Commande')->nullable();
            $table->string('num_Bl')->nullable();
            $table->string('navire')->nullable();
            $table->string('destination')->nullable();
            $table->string('amateur')->nullable();
            $table->string('num_Dossier')->nullable();
            $table->string('num_Ot')->nullable();
            $table->string('volume')->nullable();
            $table->string('facturier_uuid')->nullable();
            $table->string('poste_occuper')->nullable();
            $table->string('num_facture')->nullable();
            $table->date('date_echeance')->nullable();
            $table->string('condition_paiement')->nullable();
            $table->date('date_sendToClient')->nullable();
            $table->string('user_sendToClient')->nullable();
            $table->date('date_payed')->nullable();
            $table->string('user_payed')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refacturations');
    }
};
