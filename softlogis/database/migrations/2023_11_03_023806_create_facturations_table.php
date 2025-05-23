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
        Schema::create('facturations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->string('code')->nullable();
            $table->string('etat')->nullable()->default('actif');
            $table->enum('statut', ['reccording', 'good_pay', 'payed', 'cancel'])->default('reccording');
            $table->string('numFacture')->nullable();

            $table->string('typeFacture')->nullable();
            $table->date('date_echeance')->nullable();

            $table->string('transitaire_uuid')->nullable();
            $table->string('transporteur_uuid')->nullable();

            $table->string('facture_original')->nullable();

            $table->string('num_bl')->nullable();
            $table->string('file_Bl')->nullable();

            $table->string('user_create')->nullable();
            $table->string('user_payed')->nullable();
            $table->date('date_paiement')->nullable();

            $table->longText('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturations');
    }
};
