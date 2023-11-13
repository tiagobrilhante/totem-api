<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaImagemEventoAdicionals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imagem_evento_adicionals', function (Blueprint $table) {
            $table->id();
            $table->string('imagem');
            $table->longText('descricao')->nullable();
            $table->longText('fonte')->nullable();
            $table->bigInteger('evento_id')->unsigned()->index();
            $table->foreign('evento_id')
                ->references('id')
                ->on('eventos')->onDelete('cascade');
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
        Schema::dropIfExists('imagem_evento_adicionals');
    }
}
