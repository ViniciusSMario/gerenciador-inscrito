<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMercadoPagoSettingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('mercado_pago_settings', function (Blueprint $table) {
            $table->id();
            $table->string('access_token')->comment('Token de acesso do Mercado Pago');
            $table->boolean('sandbox')->default(true)->comment('Define se está no ambiente de sandbox ou produção');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('mercado_pago_settings');
    }
}
