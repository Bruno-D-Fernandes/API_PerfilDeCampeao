<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            if (!Schema::hasColumn('messages', 'evento_id')) {
                $table->foreignId('evento_id')
                    ->nullable()
                    ->constrained('eventos')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            if (Schema::hasColumn('messages', 'evento_id')) {
                $table->dropForeign(['evento_id']);
                $table->dropColumn('evento_id');
            }
        });
    }
};
