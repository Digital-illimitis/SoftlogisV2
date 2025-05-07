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
        Schema::create('expedition_products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('famille_uuid')->nullable();
            $table->string('etat')->default('actif');
            $table->foreignId('expedition_id');
            $table->foreignId('product_id');

            $table->foreign('expedition_id')->references('id')->on('expeditions');
            $table->foreign('product_id')->references('id')->on('articles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedition_products');
    }
};
