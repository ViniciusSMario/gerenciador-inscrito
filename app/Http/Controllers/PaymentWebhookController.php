<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Inscrito;
use MercadoPago\SDK;
use Illuminate\Http\JsonResponse;
use App\Mail\PagamentoConfirmadoMail;
use Illuminate\Support\Facades\Mail;

class PaymentWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Adiciona um log para verificar se o webhook foi recebido
        Log::info('Webhook recebido:', $request->all());

        // Verifica o tipo de notificação
        if ($request->type == 'payment') {
            $paymentId = $request->data['id'] ?? null;

            if (!$paymentId) {
                Log::error('ID do pagamento não encontrado na notificação.');
                return response()->json(['error' => 'ID do pagamento não encontrado'], 400);
            }

            // Inicializa o SDK do Mercado Pago
            SDK::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));

            // Tenta obter os detalhes do pagamento pelo ID
            $payment = \MercadoPago\Payment::find_by_id($paymentId);

            if (!$payment) {
                Log::error("Pagamento não encontrado para o ID: $paymentId");
                return response()->json(['error' => 'Pagamento não encontrado'], 404);
            }

            // Verifica se o pagamento foi aprovado
            if ($payment->status == 'approved') {
                // Busca o inscrito pelo external_reference (ID do inscrito)
                $inscrito = Inscrito::find($payment->external_reference);

                if (!$inscrito) {
                    Log::error("Inscrito não encontrado para o external_reference: {$payment->external_reference}");
                    return response()->json(['error' => 'Inscrito não encontrado'], 404);
                }

                // Atualiza o status do inscrito para "pago"
                $inscrito->status_pagamento = 'pago';
                $inscrito->save();

                Log::info("Status do inscrito atualizado para 'pago' para o inscrito ID: {$inscrito->id}");

                // Envia o e-mail de confirmação
                Mail::to($inscrito->email)->queue(new PagamentoConfirmadoMail($inscrito));

                Log::info("Status do inscrito atualizado para 'pago' e e-mail de confirmação enviado para o inscrito ID: {$inscrito->id}");
            } else {
                Log::info("Pagamento não aprovado para o ID: $paymentId. Status: {$payment->status}");
            }
        } else {
            Log::info("Notificação recebida de tipo desconhecido: {$request->type}");
        }

        return response()->json(['status' => 'success'], 200);
    }

    public function verificarPagamento(Inscrito $inscrito): JsonResponse
    {
        return response()->json(['status' => $inscrito->status_pagamento]);
    }
}

