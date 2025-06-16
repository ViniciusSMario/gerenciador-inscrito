<?php

namespace App\Http\Controllers;

use App\Models\MercadoPagoSetting;
use Illuminate\Http\Request;

class MercadoPagoController extends Controller
{
    public function index()
    {
        $config = MercadoPagoSetting::first();
        return view('mercadopago.index', compact('config'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'access_token' => 'required|string',
            'sandbox' => 'required|boolean',
        ]);

        // Atualiza ou cria as configurações
        MercadoPagoSetting::updateOrCreate(
            ['id' => 1], // Atualiza sempre o primeiro registro
            [
                'access_token' => $request->access_token,
                'sandbox' => $request->sandbox,
            ]
        );

        return redirect()->route('mercadopago.index')->with('success', 'Configurações atualizadas com sucesso!');
    }
}

