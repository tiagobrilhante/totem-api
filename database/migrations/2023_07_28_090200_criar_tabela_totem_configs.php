<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaTotemConfigs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('totem_configs', function (Blueprint $table) {
            $table->id();
            $table->string('nome_totem');
            $table->integer('altura_index');
            $table->integer('largura_index');
            $table->integer('altura_detail');
            $table->integer('largura_detail');
            $table->string('tipo_totem');
            $table->integer('access_code');
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
        Schema::dropIfExists('totem_configs');
    }
}
