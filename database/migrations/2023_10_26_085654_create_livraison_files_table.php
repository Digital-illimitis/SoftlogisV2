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
        Schema::create('livraison_files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->unsignedBigInteger('livraison_id');
            $table->string('name')->nullable();
            $table->string('files')->nullable();
            $table->string('filePath')->nullable();
            $table->string('etat')->default('actif');

            $table->foreign('livraison_id')->references('id')->on('od_livraisons');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livraison_files');
    }
};
