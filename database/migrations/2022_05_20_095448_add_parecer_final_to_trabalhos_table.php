<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParecerFinalToTrabalhosTable extends Migration
{
    /**
     * Run the migrations.
     * Adicionar coluna para definir o parecer final da comissão.
     * @return void
     */
    public function up()
    {
        Schema::table('trabalhos', function (Blueprint $table) {
            $table->boolean('parecer_final')->nullable();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trabalhos', function (Blueprint $table) {
            $table->dropColumn('parecer_final');
        });
    }
}
