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
        Schema::create('postagem_images', function (Blueprint $table) { // essa tabela de imagens pode ter o tipo "$table->morphs('imageable')"
            $table->id();                                           // estou fazendo de um jeito mais simples, já que não decidiram muita
            $table->foreignId('idImagem')->references('id')->on('postagens'); // coisa do aplicativo que afetaria o MER --ass: Bruno
            $table->text('camonhoImagem');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postagem_images');
    }
};
