<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCpfToInscritosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('inscritos', function (Blueprint $table) {
            $table->string('cpf', 14)->nullable()->after('email')->unique()->comment('CPF do inscrito');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('inscritos', function (Blueprint $table) {
            $table->dropColumn('cpf');
        });
    }
}
