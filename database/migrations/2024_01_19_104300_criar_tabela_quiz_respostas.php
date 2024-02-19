<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaQuizRespostas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {



        Schema::create('quiz_respostas', function (Blueprint $table) {
            $table->id();
            $table->longText('resposta');
            $table->boolean('correta');
            $table->bigInteger('quiz_pergunta_id')->unsigned()->index();
            $table->foreign('quiz_pergunta_id')
                ->references('id')
                ->on('quiz_perguntas')->onDelete('cascade');
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
        Schema::table('quiz_respostas', function (Blueprint $table) {
            //
        });
    }
}
