<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('financial_profiles', function (Blueprint $table) {
            $table->unsignedInteger('idade_actual')->nullable()->after('user_id');
            $table->decimal('retorno_investimento_anual', 5, 2)->nullable()->default(6.00)->after('montante_aposentadoria');
            $table->decimal('inflacao_anual', 5, 2)->nullable()->default(10.00)->after('retorno_investimento_anual');
        });
    }

    public function down(): void
    {
        Schema::table('financial_profiles', function (Blueprint $table) {
            $table->dropColumn('idade_actual');
            $table->dropColumn('retorno_investimento_anual');
            $table->dropColumn('inflacao_anual');
        });
    }
};
