<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLangsToAssuntosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assuntos', function (Blueprint $table) {
            $table->string('nome_assunto_es')->after('nome_assunto')->nullable();
            $table->string('nome_assunto_en')->after('nome_assunto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assuntos', function (Blueprint $table) {
            //
        });
    }
}
