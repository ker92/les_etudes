<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('annees', function (Blueprint $table) {
            $table->id();
            $table->string('annee')->unique(); // évite les doublons
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('annees');
    }
};
