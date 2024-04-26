<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMelhoriaLangsToTotemConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('totem_configs', function (Blueprint $table) {
            $table->dropColumn('selected_lang');
        });
        Schema::table('totem_configs', function (Blueprint $table) {
            $table->boolean('permite_multi_lang')->after('nome_totem')->default(true);
            $table->boolean('es_habilitado')->after('permite_multi_lang')->default(true);
            $table->boolean('en_habilitado')->after('permite_multi_lang')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('totem_configs', function (Blueprint $table) {
            //
        });
    }
}
