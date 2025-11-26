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
        Schema::table('eventos', function (Blueprint $table) {
            $table->foreignId('clube_id')
                ->after('id')
                ->constrained('clubes')
                ->cascadeOnDelete();

            $table->string('titulo', 255)->after('clube_id');
            $table->text('descricao')->nullable()->after('titulo');

            $table->dateTime('data_hora_inicio')->after('descricao');
            $table->dateTime('data_hora_fim')->nullable()->after('data_hora_inicio');

            $table->string('cep', 9)->nullable()->after('data_hora_fim');
            $table->string('estado', 2)->nullable()->after('cep');
            $table->string('cidade', 100)->nullable()->after('estado');
            $table->string('bairro', 100)->nullable()->after('cidade');
            $table->string('rua', 150)->nullable()->after('bairro');
            $table->string('numero', 20)->nullable()->after('rua');
            $table->string('complemento', 150)->nullable()->nullable()->after('numero');

            $table->unsignedInteger('limite_participantes')->nullable()->after('complemento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropForeign(['clube_id']);
            $table->dropColumn([
                'clube_id',
                'titulo',
                'descricao',
                'data_hora_inicio',
                'data_hora_fim',
                'cep',
                'estado',
                'cidade',
                'bairro',
                'rua',
                'numero',
                'complemento',
                'limite_participantes',
            ]);
        });
    }
};
