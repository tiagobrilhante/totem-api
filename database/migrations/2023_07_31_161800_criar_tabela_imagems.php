<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaImagems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imagems', function (Blueprint $table) {
            $table->id();
            $table->integer('ordem');
            $table->string('nome')->nullable();
            $table->string('imagem');
            $table->longText('legenda')->nullable();
            $table->boolean('banner');
            $table->bigInteger('assunto_id')->unsigned()->index();
            $table->foreign('assunto_id')
                ->references('id')
                ->on('assuntos')->onDelete('cascade');
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
        Schema::dropIfExists('imagems');
    }
}
