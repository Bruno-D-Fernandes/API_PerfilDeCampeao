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
        Schema::create('esportes', function (Blueprint $table) {
            $table->id();
            $table->string('nomeEsporte', 100);
            $table->text('descricaoEsporte')->nullable();
            $table->enum('status', ['ativo','deletado'])->default('ativo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esportes');
    }
};
