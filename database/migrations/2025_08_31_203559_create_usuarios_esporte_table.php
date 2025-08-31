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
        Schema::create('usuarios_esporte', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('tbusuario')->onDelete('cascade');
            $table->foreignId('esporte_id')->constrained('esportes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios_esporte');
    }
};
