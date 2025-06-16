<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPresencaConfirmadaToInscritosTable extends Migration
{
    public function up()
    {
        Schema::table('inscritos', function (Blueprint $table) {
            $table->boolean('presenca_confirmada')->default(false)->after('estado_civil');
        });
    }

    public function down()
    {
        Schema::table('inscritos', function (Blueprint $table) {
            $table->dropColumn('presenca_confirmada');
        });
    }
}
