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
        Schema::create('perfil_caracteristicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perfil_id')->constrained('perfis')->onDelete('cascade');
            $table->foreignId('caracteristica_id')->constrained('caracteristicas')->onDelete('cascade');
            $table->string('valor'); // Ex: "80", "1.75", "Canhoto"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfil_caracteristicas');
    }
};
