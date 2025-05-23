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
        Schema::create('familly_groups', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->string('code')->nullable();
            $table->string('libelle')->nullable();
            $table->longText('description')->nullable();
            $table->string('etat')->default('actif');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('familly_groups');
    }
};
