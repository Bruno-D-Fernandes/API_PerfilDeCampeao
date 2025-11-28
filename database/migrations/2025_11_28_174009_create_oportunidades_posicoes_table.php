<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('oportunidades_posicoes', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('oportunidades_id');
            $table->foreign('oportunidades_id')
                  ->references('id')
                  ->on('oportunidades')
                  ->onDelete('cascade');

 
            $table->unsignedBigInteger('posicoes_id');
            $table->foreign('posicoes_id')
                  ->references('id')
                  ->on('posicoes')
                  ->onDelete('cascade');

            $table->timestamps();

   
            $table->unique(['oportunidades_id', 'posicoes_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('oportunidades_posicoes');
    }
};
