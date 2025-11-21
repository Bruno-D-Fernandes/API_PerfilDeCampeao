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
        Schema::create('oportunidade_caracteristicas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('oportunidade_id')
                ->constrained('oportunidades')
                ->onDelete('cascade');

            $table->foreignId('caracteristica_id')
                ->constrained('caracteristicas')
                ->onDelete('cascade');

            $table->unsignedInteger('valor_min')->nullable();
            $table->unsignedInteger('valor_max')->nullable();

            $table->timestamps();
        }); 

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oportunidade_caracteristicas');
    }
};
