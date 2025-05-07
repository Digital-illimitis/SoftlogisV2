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
        Schema::create('expedition__files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index()->nullable();
            $table->unsignedBigInteger('expedition_id');
            $table->string('name')->nullable();
            $table->string('files')->nullable();
            $table->string('filePath')->nullable();
            $table->string('etat')->default('actif');
            $table->enum('statut', ['waiting', 'refused', 'validate'])->nullable()->default('waiting');
            $table->timestamps();

            $table->foreign('expedition_id')->references('id')->on('expeditions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedition__files');
    }
};
