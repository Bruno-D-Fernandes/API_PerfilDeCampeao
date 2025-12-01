<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('conversation_id')
                ->constrained('conversations')
                ->cascadeOnDelete();

            $table->morphs('sender');
            $table->morphs('receiver');

            $table->text('message');
            $table->enum('type', ['text', 'convite', 'image'])->default('text');

            $table->json('payload')->nullable();
            $table->boolean('is_read')->default(false);

            $table->foreignId('evento_id')
                ->nullable()
                ->constrained('eventos')
                ->cascadeOnDelete();

            $table->foreignId('convite_evento_id')
                ->nullable()
                ->constrained('convites_evento')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
