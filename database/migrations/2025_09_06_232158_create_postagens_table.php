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
        Schema::create('postagens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idUsuario')->references('id')->on('usuarios');            
            $table->text('textoPostagem')->nullable();
            $table->string('localizacaoPostagem')->nullable(); // não sei se vai ficar assim mesmo | tavez usar api de locali do google?
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postagens');
    }
};
