<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sourcings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->string('code')->nullable();
            $table->string('etat')->default('actif');
            $table->enum('statut', ['draft', 'started', 'validateDoc','odTransit', 'odlivraison','received', 'stocked'])->default('draft');
            $table->string('id_navire')->nullable();
            $table->enum('packaging', ['roro', 'container'])->nullable();
            $table->longText('info_navire')->nullable();
            $table->string('date_arriver')->nullable();
            $table->string('date_depart')->nullable();
            $table->longText('note')->nullable();
            $table->string('created_by')->nullable();

            $table->date('date_receivFactCom')->nullable();
            $table->string('is_receivFactCom')->default('false');

            $table->string('tostarted_by')->nullable();
            $table->string('tostarted_date')->nullable();

            $table->string('startValidate_by')->nullable();
            $table->string('startValidate_date')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sourcings');
    }
};
