<?php

use App\Models\Sourcing;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sourcing_files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index()->nullable();
            $table->unsignedBigInteger('sourcing_id');
            $table->string('name')->nullable();
            $table->string('files')->nullable();
            $table->string('filePath')->nullable();
            $table->string('etat')->default('actif');
            $table->enum('statut', ['waiting', 'refused', 'validate'])->nullable();

            $table->string('uuid_validator')->nullable();
            $table->string('date_validation')->nullable();
            $table->string('uuid_reject')->nullable();
            $table->string('date_reject')->nullable();
            $table->timestamps();

            $table->foreign('sourcing_id')->references('id')->on('sourcings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sourcing_files');
    }
};
