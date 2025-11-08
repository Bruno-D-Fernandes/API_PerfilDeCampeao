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
        Schema::table('tbadm', function (Blueprint $table) {
            $table->string('nome');
            $table->string('endereco')->nullable()->after('email');
            $table->string('telefone')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('foto_perfil')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbadm', function (Blueprint $table) {
            $table->dropColumn(['nome', 'endereco', 'telefone', 'data_nascimento', 'foto_perfil']);
        });
    }
};
