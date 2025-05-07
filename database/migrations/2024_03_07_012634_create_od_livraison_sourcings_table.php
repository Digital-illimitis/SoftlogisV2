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
        Schema::create('od_livraison_sourcings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('od_livraison_id');
            $table->unsignedBigInteger('sourcing_id');
            $table->timestamps();

            $table->foreign('od_livraison_id')->references('id')->on('od_livraisons')->onDelete('cascade');
            $table->foreign('sourcing_id')->references('id')->on('sourcings')->onDelete('cascade');
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('od_livraison_sourcings');
    }
};
