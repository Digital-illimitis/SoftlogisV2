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
        Schema::create('stock_updates', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->unsignedBigInteger('product_id');
            $table->string('mouvement')->default('In'); // In, Out
            $table->string('file')->nullable();
            $table->string('conformity')->default('indefinie'); // on ,off
            $table->longText('note')->nullable();
            $table->string('conformityOut')->default('null'); // on ,off
            $table->longText('noteOut')->nullable();
            $table->string('entrepot_uuid')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('product_id')->references('id')->on('articles');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_updates');
    }
};
