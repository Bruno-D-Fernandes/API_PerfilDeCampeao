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
        Schema::table('oportunidades', function (Blueprint $table) {
             // Requisitos de idade (opcionais)
            $table->unsignedTinyInteger('idadeMinima')->nullable(); // 0–255
            $table->unsignedTinyInteger('idadeMaxima')->nullable();

            // Local da oportunidade
            $table->string('estadoOportunidade', 2)->nullable();     // Ex: 'SP'
            $table->string('cidadeOportunidade', 100)->nullable();   // Ex: 'São Paulo'
            $table->string('enderecoOportunidade', 255)->nullable(); // Rua/Av, nº, etc
            $table->string('cepOportunidade', 9)->nullable();        // Ex: 01311-000

             $table->index(['esporte_id', 'posicoes_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('oportunidades', function (Blueprint $table) {
        $table->dropColumn([
            'idadeMinima','idadeMaxima',
            'estadoOportunidade','cidadeOportunidade',
            'enderecoOportunidade','cepOportunidade',
        ]);
    });
    }
};
