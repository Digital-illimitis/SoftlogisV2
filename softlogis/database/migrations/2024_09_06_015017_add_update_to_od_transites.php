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
        Schema::table('ex_transits', function (Blueprint $table) {
            $table->string('numConnaiOriginal')->nullable();
            $table->string('navireName')->nullable();
            $table->string('numConnaissement')->nullable();
            $table->string('portDembarquement')->nullable();
            $table->string('factFounisseur')->nullable();
            $table->string('factFret')->nullable();
            $table->string('colisage')->nullable();
            $table->string('assurCertifNum')->nullable();
            $table->string('frie')->nullable();
            $table->string('sgsn')->nullable();
            $table->string('numLicense')->nullable();
            $table->string('exoneration')->nullable();
            $table->string('marche')->nullable();
            $table->string('marchandiseAction')->nullable();
            $table->string('expediteTo')->nullable();
            $table->string('droitCredit')->nullable();
            $table->string('factAlibelle')->nullable();
            $table->string('divers')->nullable();
            $table->string('garantieBancaire')->nullable();
            $table->text('adresseLivraison')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ex_transits', function (Blueprint $table) {
            //
        });
    }
};
