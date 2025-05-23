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
        Schema::table('od_livraisons', function (Blueprint $table) {
            $table->string('numOt')->nullable();
            $table->string('numFolder')->nullable();
            $table->string('numBl')->nullable();
            $table->string('trajetStart_uuid')->nullable();
            $table->string('trajetEnd_uuid')->nullable();
            $table->string('refCotation')->nullable();
            $table->string('nbrMachine')->nullable();
            $table->string('productUuid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       //
    }
};
