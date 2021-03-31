<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaChamadaTipoAtendimentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()

    {
        Schema::create('chamada_tipo_atendimentos', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('tipo_atendimento_id')->unsigned()->index();
            $table->foreign('tipo_atendimento_id')
                ->references('id')
                ->on('tipo_atendimentos')->onDelete('cascade');

            $table->bigInteger('chamada_id')->unsigned()->index();
            $table->foreign('chamada_id')
                ->references('id')
                ->on('chamadas')->onDelete('cascade');


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
        Schema::dropIfExists('chamada_tipo_atendimentos');
    }
}
