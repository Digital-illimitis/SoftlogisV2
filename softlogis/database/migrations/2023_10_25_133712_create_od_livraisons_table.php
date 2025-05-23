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
        Schema::create('od_livraisons', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->string('code')->unique();
            $table->string('etat')->default('actif');
            $table->longText('note')->nullable();

            $table->string('transporteur_uuid')->nullable();
            $table->string('date_livraison')->nullable();
            $table->string('lieu_livraison')->nullable();
            
            $table->string('created_by')->nullable();

            $table->string('sourcing_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('od_livraisons');
    }
};
