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
        Schema::create('ex_transite_files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->string('transite_uuid');
            $table->string('name')->nullable();
            $table->string('files')->nullable();
            $table->string('user_uuid')->nullable();
            $table->string('filePath')->nullable();
            $table->string('etat')->default('actif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ex_transite_files');
    }
};
