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
        Schema::create('tbusuario', function (Blueprint $table) {
            $table->id();
            $table->string('nomeCompleto');
            $table->string('nomeUsuario')->unique();
            $table->string('emailUsuario')->unique();
            $table->string('senhaUsuario');
            
            $table->string('nacionalidadeUsuario')->nullable();
            $table->date('dataNascimentoUsuario')->nullable();
            $table->dateTime('dataCadastroUsuario')->nullable();
            
            $table->string('fotoPerfilUsuario')->nullable();
            $table->string('fotoBannerUsuario')->nullable();
            $table->text('bioUsuario')->nullable();
            
            $table->decimal('alturaCm', 5, 2)->nullable();
            $table->decimal('pesoKg', 5, 2)->nullable();
            
            $table->string('peDominante')->nullable();
            $table->string('maoDominante')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbusuario');
    }
};
