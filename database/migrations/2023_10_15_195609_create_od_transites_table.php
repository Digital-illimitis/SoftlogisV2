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
        Schema::create('od_transites', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->string('code')->nullable();
            $table->string('etat')->default('actif');
            $table->text('note')->nullable();
            $table->string('transitaire_uuid')->nullable();
            $table->string('sourcing_uuid')->nullable();
            $table->string('receive_doc')->default('Off');
            $table->date('receive_date')->nullable();
            $table->string('user_uuid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('od_transites');
    }
};
