<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chat_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Usuário que fez a pergunta
            $table->text('question');       // Pergunta do usuário
            $table->text('response')->nullable(); // Resposta da Grok IA
            $table->string('category')->nullable(); // Categoria ou tipo de pergunta
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_questions');
    }
};
