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
        Schema::create('exp_transports', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->string('code');
            $table->string('etat')->default('actif');
            $table->string('voie_exp')->nullable();

            $table->string('transporteur_uuid')->nullable();
            $table->string('expedition_uuid')->nullable();
            $table->LongText('note')->nullable();
            $table->string('destination')->nullable();
            $table->date('date_transport')->nullable();
            $table->string('user_uuid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exp_transports');
    }
};
