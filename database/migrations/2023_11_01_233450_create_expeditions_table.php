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
        Schema::create('expeditions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('code')->nullable();
            $table->string('etat')->nullable();
            $table->string('num_exp')->nullable();
            $table->text('incoterm')->nullable();
            $table->string('lieu_liv')->nullable();
            $table->date('date_liv')->nullable();
            $table->string('created_by')->nullable();
            $table->date('date_started')->nullable();
            $table->date('date_validate_doc')->nullable();
            $table->date('date_transit')->nullable();
            $table->date('date_transport')->nullable();
            $table->date('date_destockage')->nullable();

            $table->string('client_uuid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expeditions');
    }
};
