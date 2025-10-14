<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('oportunidades', function (Blueprint $table) {
            $table->enum('status', ['pending','approved','rejected'])->default('pending')->after('cepOportunidade');
            $table->foreignId('reviewed_by')->nullable()->constrained('tbadm')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->string('rejection_reason', 255)->nullable();
        });
    }

    public function down(): void {
        Schema::table('oportunidades', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reviewed_by');
            $table->dropColumn(['status','reviewed_at','rejection_reason']);
        });
    }
};
