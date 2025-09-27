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
        Schema::create('perfil_posicao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perfil_id')->references('id')->on('perfis')->onDelete('cascade');
            $table->foreignId('posicao_id')->references('id')->on('posicoes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfil_posicao');
    }
};
