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
            $table->string('nomeUsuario', 100)->nullable();
            $table->string('emailUsuario', 255)->unique();
            $table->string('senhaUsuario', 255);
            $table->string('nacionalidadeUsuario', 100)->nullable();
            $table->date('dataNascimentoUsuario')->nullable();
            $table->string('generoUsuario', 50)->nullable();

            $table->string('estadoUsuario', 100)->nullable();
            $table->string('cidadeUsuario', 100)->nullable();
            
            
            $table->date('dataCadastroUsuario')->nullable();
            
            
            $table->text('bioUsuario')->nullable();


            $table->integer('alturaCm')->nullable();
            $table->float('pesoKg')->nullable();
            $table->string('peDominante', 50)->nullable();
            $table->string('maoDominante', 50)->nullable();
            $table->string('temporadasUsuario', 50)->nullable();

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
