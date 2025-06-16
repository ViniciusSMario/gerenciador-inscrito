@extends('app', ['activePage' => 'mercadopago', 'titlePage' => 'Configurar Pagamento'])

@section('title', 'Configurações do MercadoPago')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible text-white" role="alert">
                            <span class="text-sm">{{ session('success') }}</span>
                            <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form id="mercadopago-form" action="{{ route('mercadopago.store') }}" method="POST">
                        @csrf
                        
                        <!-- Token -->
                        <div class="row">
                            <div class="input-group input-group-static mb-4">
                                <label for="access_token">Token do Mercado Pago</label>
                                <input id="access_token" class="form-control" name="access_token" type="text" 
                                    value="{{ $config->access_token ?? '' }}" required>
                            </div>
                        </div>

                        <!-- Sandbox -->
                        <div class="row">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="sandbox" value="1" 
                                        {{ ($config->sandbox ?? true) ? 'checked' : '' }}>
                                    Ambiente de Sandbox
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="sandbox" value="0" 
                                        {{ ($config->sandbox ?? false) ? 'checked' : '' }}>
                                    Ambiente de Produção
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-sm btn-success" id="submitButton">
                            <i class="material-icons left" style="font-size: 20px;">save</i>Salvar Configurações
                        </button>
                    </form>

                    <!-- Loading Overlay -->
                    <div id="loadingOverlay" style="
                        display: none;
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background-color: rgba(255, 255, 255, 0.8);
                        z-index: 9999;
                        align-items: center;
                        justify-content: center;
                    ">
                        <div class="spinner-border text-success" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector('#mercadopago-form');

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                // Exibe o overlay de loading
                document.getElementById('loadingOverlay').style.display = 'flex';

                // Desativa o botão de envio e exibe o spinner interno
                document.getElementById('submitButton').disabled = true;

                setTimeout(() => form.submit(), 100);
            });
        });
    </script>
@endsection
