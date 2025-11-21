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
            
            // Campos de Dados
            $table->string('tituloOportunidades',100);
            $table->string('descricaoOportunidades', 255);
            $table->date('datapostagemOportunidades');

            // Chaves Estrangeiras (Foreign Keys)
            
            // Esporte
            $table->foreignId('esporte_id')
                  ->constrained('esportes') // Assume que sua tabela é 'esportes'
                  ->onDelete('cascade');
            
            // Posição (Singular/Plural do nome da FK não importa se você usa 'constrained')
            $table->foreignId('posicoes_id') 
                  ->constrained('posicoes') // Assume que sua tabela de posições é 'posicoes'
                  ->onDelete('cascade');
            
            // Clube
            $table->foreignId('clube_id')
                  ->constrained('clubes') // Assume que sua tabela de clubes é 'clubes'
                  ->onDelete('cascade');
            
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