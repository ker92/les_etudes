<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resultats', function (Blueprint $table) {
            $table->id();

            $table->foreignId('etudiant_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('diplome_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('annee_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->enum('statut_resultat', ['admis', 'refuse', 'rattrapage'])->nullable();
            $table->boolean('est_valide')->default(false);
            $table->boolean('est_publie')->default(false);
            $table->timestamp('date_validation')->nullable();
            $table->timestamp('date_publication')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resultats');
    }
};
