<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('listas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clube_id')->constrained('clubes')->cascadeOnDelete();
            $table->string('nome', 100);
            $table->string('descricao', 255)->nullable();
            $table->timestamps();

            $table->unique(['clube_id','nome']); // evita duas listas com o mesmo nome no mesmo clube
        });
    }
    public function down(): void {
        Schema::dropIfExists('listas');
    }
};

