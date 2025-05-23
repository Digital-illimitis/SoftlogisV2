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
        // Pour les bases de données comme MySQL, il est souvent nécessaire de recréer l'énumération
        DB::statement("ALTER TABLE expeditions MODIFY statut ENUM('draft', 'started', 'startedDoc', 'odTransit', 'odTransport', 'outStock', 'wait_exp', 'livered', 'facturer', 'orderRecu') DEFAULT 'draft'");
    }

    public function down(): void
    {
        // Revenir à l'état précédent en cas de rollback
        DB::statement("ALTER TABLE expeditions MODIFY statut ENUM('draft', 'started', 'startedDoc', 'odTransit', 'odTransport', 'outStock', 'wait_exp', 'livered') DEFAULT 'draft'");
    }
};
