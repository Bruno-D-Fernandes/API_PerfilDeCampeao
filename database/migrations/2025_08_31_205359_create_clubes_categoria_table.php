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
        Schema::create('clubes_categoria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->references('id')->on('tbusuario');
            $table->foreignId('clube_id')->references('id')->on('clubes');
            $table->string('funcao'); //tipo dono, admin, medico, jogador sla
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubes_categoria');
    }
};
