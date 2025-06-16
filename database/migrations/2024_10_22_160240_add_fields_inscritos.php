<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInscritos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inscritos', function (Blueprint $table) {
            $table->string('telefone')->after('email');
            $table->enum('estado_civil', [
                'solteiro(a)',
                'casado(a)',
                'divorciado(a)',
                'viúvo(a)',
                'separado(a) judicialmente',
                'prefiro não informar']
            )->after('telefone');
            $table->date('data_nascimento')->after('estado_civil');
            $table->boolean('autorizacao')->after('data_nascimento')->default(1);
            $table->text('observacao')->after('autorizacao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
