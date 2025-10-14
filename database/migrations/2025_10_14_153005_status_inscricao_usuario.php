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
        Schema::table('inscricoes', function (Blueprint $table) {
            $table->enum('status', ['pending','approved','rejected'])->default('pending')->after('usuario_id');
            $table->foreignId('reviewed_by')->nullable()->constrained('clubes')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inscricoes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reviewed_by');
            $table->dropColumn(['status','reviewed_at']);
        });
    }
};
