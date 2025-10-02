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
        Schema::create('oportunidades', function (Blueprint $table) {
            $table->id();
            $table->string('descricaoOportunidades', 255);
            $table->date('datapostagemOportunidades');
            $table->foreignId('esporte_id')->references('id')->on('esportes');
            $table->foreignId('posicoes_id')->references('id')->on('posicoes');
            $table->foreignId('clube_id')->references('id')->on('clubes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oportunidades');
    }
};
