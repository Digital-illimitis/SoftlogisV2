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
        Schema::create('sourcing_products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('famille_uuid')->nullable();
            $table->string('etat')->default('actif');
            $table->boolean('is_received')->default(false);
            $table->foreignId('sourcing_id');
            $table->foreignId('product_id');
            $table->timestamps();

            $table->foreign('sourcing_id')->references('id')->on('sourcings');
            $table->foreign('product_id')->references('id')->on('articles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sourcing_products');
    }
};
