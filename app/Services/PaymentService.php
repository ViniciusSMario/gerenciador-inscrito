<?php

namespace App\Services;

use App\Models\MercadoPagoSetting;
use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;

class PaymentService
{
    public function __construct()
    {
        // Busca as configurações do Mercado Pago no banco de dados
        $settings = MercadoPagoSetting::first();

        if (!$settings || !$settings->access_token) {
            throw new \Exception('As configurações do Mercado Pago não estão configuradas corretamente.');
        }

        // Define o token e o ambiente no SDK
        SDK::setAccessToken($settings->access_token);

        if ($settings->sandbox) {
            SDK::setIntegratorId('sandbox'); // Define como ambiente de teste
        }
    }

    public function criarPagamento($descricao, $valor, $quantidade, $inscrito)
    {
        try {
            $preference = new Preference();

            $item = new Item();
            $item->title = $descricao;
            $item->quantity = $quantidade;
            $item->currency_id = "BRL";
            $item->unit_price = $valor;

            $preference->items = [$item];
            $preference->external_reference = $inscrito->id; // ID do inscrito ou outro identificador único

            $preference->save();

            return $preference->init_point; // Link para redirecionar o cliente ao pagamento
        } catch (\Exception $e) {
            throw new \Exception('Erro ao criar pagamento no Mercado Pago: ' . $e->getMessage());
        }
    }
}
