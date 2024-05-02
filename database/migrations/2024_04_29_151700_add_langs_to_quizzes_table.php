<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLangsToQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->longText('cabecalho_es')->after('cabecalho')->nullable();
            $table->longText('cabecalho_en')->after('cabecalho')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            //
        });
    }
}
