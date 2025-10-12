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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nomeCompletoUsuario', 255);
            $table->string('emailUsuario', 255)->unique();
            $table->string('senhaUsuario', 255);
            $table->date('dataNascimentoUsuario');
            $table->string('generoUsuario', 50)->nullable();;
            $table->string('estadoUsuario', 100)->nullable();;
            $table->string('cidadeUsuario', 100)->nullable();;
            $table->integer('alturaCm')->nullable();;
            $table->float('pesoKg')->nullable();;
            $table->string('peDominante', 50)->nullable();;
            $table->string('maoDominante', 50)->nullable();;
            $table->string('fotoPerfilUsuario')->nullable();
            $table->string('fotoBannerUsuario')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
