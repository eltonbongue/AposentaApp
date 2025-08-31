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
    Schema::table('financial_profiles', function (Blueprint $table) {
        $table->integer('duracao_aposentadoria')->nullable(); // ou ->default(0), se quiser valor padrão
    });
}

public function down()
{
    Schema::table('financial_profiles', function (Blueprint $table) {
        $table->dropColumn('duracao_aposentadoria');
    });
}

};
