<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('cpf')->unique();
            $table->string('nome');
            $table->string('nome_guerra');
            $table->string('posto_grad');
            $table->string('tipo');
            $table->string('password');
            $table->bigInteger('om_id')->unsigned()->index();

            $table->timestamps();
            $table->foreign('om_id')
                ->references('id')
                ->on('oms');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
