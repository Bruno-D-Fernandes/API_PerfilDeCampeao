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
        Schema::create('clubes', function (Blueprint $table) {

            $table->id();

            $table->string('nomeClube')->unique();
            $table->string('cnpjClube')->unique();
            $table->string('emailClube')->unique();
            $table->string('cidadeClube');
            $table->string('estadoClube');
            $table->date('anoCriacaoClube');
            $table->string('enderecoClube');
            $table->text('bioClube')->nullable();
            $table->string('senhaClube', 255);
            $table->foreignId('categoria_id')->references('id')->on('categorias');
            $table->foreignId('esporte_id')->references('id')->on('esportes')->onDelete('cascade'); // ou 'idEsporte'
            $table->string('fotoPerfilClube')->nullable();
            $table->string('fotoBannerClube')->nullable();

            $table->enum('status', ['ativo', 'pendente','rejeitado', 'bloqueado'])->default('pendente');
            $table->timestamp('reviewed_at')->nullable();
            $table->string('rejection_reason', 255)->nullable();
            $table->string('bloque_reason', 255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubes');
    }
};
