<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLangsToQuizRespostasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quiz_respostas', function (Blueprint $table) {
            $table->longText('resposta_es')->after('resposta')->nullable();
            $table->longText('resposta_en')->after('resposta')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quiz_respostas', function (Blueprint $table) {
            //
        });
    }
}
