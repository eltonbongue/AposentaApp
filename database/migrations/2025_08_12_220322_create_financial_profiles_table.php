<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('financial_profiles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->decimal('salario_actual', 15, 2)->default(0);
        $table->decimal('poupanca', 15, 2)->default(0);
        $table->decimal('investimentos', 15, 2)->nullable();
        $table->decimal('montante_aposentadoria', 15, 2);
        $table->integer('idade_aposentadoria');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_profiles');
    }
};
