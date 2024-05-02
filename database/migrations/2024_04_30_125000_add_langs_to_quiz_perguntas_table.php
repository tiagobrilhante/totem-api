<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLangsToQuizPerguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quiz_perguntas', function (Blueprint $table) {
            $table->longText('enunciado_es')->after('enunciado')->nullable();
            $table->longText('enunciado_en')->after('enunciado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quiz_perguntas', function (Blueprint $table) {
            //
        });
    }
}
