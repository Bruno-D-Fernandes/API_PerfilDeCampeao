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
        Schema::table('tbclubes', function (Blueprint $table) {
            $table->string('cnpj',14)->unique()->after('siteClube');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbclubes', function (Blueprint $table) {
            $table->dropColumn('cnpj');
        });
    }
};
