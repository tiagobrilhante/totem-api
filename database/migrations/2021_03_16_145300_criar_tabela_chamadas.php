<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaChamadas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()

    {
        Schema::create('chamadas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->string('tipo_atendimento')->nullable();
            $table->bigInteger('numero_ref')->nullable();
            $table->string('nome_ref')->nullable();
            $table->string('status');
            $table->string('chamador');
            $table->boolean('rechamada');

            $table->bigInteger('panel_id')->unsigned()->index();
            $table->foreign('panel_id')
                ->references('id')
                ->on('panels')->onDelete('cascade');

            $table->bigInteger('guiche_id')->unsigned()->index();
            $table->foreign('guiche_id')
                ->references('id')
                ->on('guiches')->onDelete('cascade');

            $table->bigInteger('tipo_atendimento_id')->unsigned()->index()->nullable();
            $table->foreign('tipo_atendimento_id')
                ->references('id')
                ->on('tipo_atendimentos')->onDelete('cascade');

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
        Schema::dropIfExists('chamadas');
    }
}
