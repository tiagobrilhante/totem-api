<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaQuizEstatisticas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_estatisticas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('quiz_id')->unsigned()->index();
            $table->foreign('quiz_id')
                ->references('id')
                ->on('quizzes')->onDelete('cascade');
            $table->integer('score');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quiz_estatisticas', function (Blueprint $table) {
            //
        });
    }
}
