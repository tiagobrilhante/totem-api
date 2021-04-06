<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaMensagems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()

    {
        Schema::create('mensagems', function (Blueprint $table) {
            $table->id();

            $table->longText('mensagem');
            $table->string('responsavel');
            $table->bigInteger('om_id')->unsigned()->index();
            $table->foreign('om_id')
                ->references('id')
                ->on('oms')->onDelete('cascade');


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
        Schema::dropIfExists('mensagems');
    }
}
