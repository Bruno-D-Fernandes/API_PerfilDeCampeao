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
        Schema::table('clubes', function (Blueprint $table) {
            $table->foreignId('reviewed_by')
            ->nullable()
            ->constrained('tbadm')
            ->nullOnDelete()
            ->after('bloque_reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clubes', function (Blueprint $table) {
            //
        });
    }
};
