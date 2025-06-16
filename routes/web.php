<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\InscricaoController;
use App\Http\Controllers\InscritoController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\PagSeguroController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PaymentWebhookController;
use App\Models\Evento;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', function () {
    return view('login');
});

/** Inscrição Externa */
Route::get('inscricao/{token}/{ticket_id}', [InscricaoController::class, 'create'])->name('inscricao.create');
Route::post('inscricao', [InscricaoController::class, 'store'])->name('inscricao.store');

/** Inscrição Confirmação e QrCode */
Route::get('/inscricao/evento/confirmar/{token}', [InscricaoController::class, 'confirmarPresenca'])->name('inscricao.confirmar');
Route::get('/inscricao/acesso/qrcode/{token}', [InscricaoController::class, 'acessoComQRCode'])->name('inscricao.acessoComQRCode');
Route::get('/inscricao/confirmada', [InscricaoController::class, 'inscricaoConfirmada'])->name('inscricao.confirmed');

/** Pagamento */
Route::get('/inscricao/api/pagar/checkout/{evento_id}/{ticket_id}/{inscrito_id}', [InscricaoController::class, 'checkout'])->name('inscricao.checkout');
Route::post('/webhook/mercadopago', [PaymentWebhookController::class, 'handleWebhook'])->name('webhook.mercadopago');
Route::get('/verificar-pagamento/{inscrito}', [PaymentWebhookController::class, 'verificarPagamento'])->name('verificar.pagamento');

/** Compartilhar */
Route::get('/eventos/compartilhar/redes/{id}', [EventoController::class, 'compartilhar'])->name('eventos.compartilhar');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/calendario', [DashboardController::class, 'showCalendario'])->name('calendario.index');
    Route::resource('dashboard', DashboardController::class);
    Route::resource('eventos', EventoController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('tickets', TicketController::class);
    Route::resource('inscritos', InscritoController::class);
    Route::get('eventos/{evento}/inscritos', [InscritoController::class, 'verInscritos'])->name('eventos.inscritos');

    Route::get('/calendario/eventos', [DashboardController::class, 'showEventosCalendario'])->name('calendario.eventos');
    Route::get('/notificacoes', [DashboardController::class, 'showNotifications'])->name('notificacoes.notificacoes');
    Route::post('/notificacoes/marcar_lido', [DashboardController::class, 'markAsRead'])->name('notificacoes.markAsRead');
    Route::get('/inscrito/evento/interno/confirmar/{token}', [InscritoController::class, 'confirmarPresencaInterna'])->name('inscrito.confirmar');

    Route::get('mercadopago', [MercadoPagoController::class, 'index'])->name('mercadopago.index');
    Route::post('mercadopago', [MercadoPagoController::class, 'store'])->name('mercadopago.store');

});

require __DIR__.'/auth.php';
