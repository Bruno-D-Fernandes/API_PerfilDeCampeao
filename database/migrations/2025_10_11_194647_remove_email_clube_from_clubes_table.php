<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clubes', function (Blueprint $table) {
            $table->dropColumn('emailClube');
        });
    }

    public function down(): void
    {
        Schema::table('clubes', function (Blueprint $table) {
            $table->string('emailClube', 255)->unique()->after('estadoClube');
        });
    }
};
