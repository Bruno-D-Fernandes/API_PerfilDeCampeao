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
            $table->string('generoUsuario', 50);
            $table->string('estadoUsuario', 100);
            $table->string('cidadeUsuario', 100);
            $table->text('bioUsuario')->nullable();

            $table->integer('alturaCm');
            $table->float('pesoKg');
            $table->string('peDominante', 50);
            $table->string('maoDominante', 50);

            //Fotos
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
