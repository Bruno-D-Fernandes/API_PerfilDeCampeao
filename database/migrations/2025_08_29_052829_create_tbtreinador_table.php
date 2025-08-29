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
        Schema::create('tbtreinador', function (Blueprint $table) {
            
            $table->id();
            $table->string('email')->unique();
            $table->string('senha');
            $table->string('nome');
            $table->string('telefone',15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbtreinador', function (Blueprint $table) {
            $table->dropColomn(['email','senha','nome','telefone']);
        });
    }
};
