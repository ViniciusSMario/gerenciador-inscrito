@extends('layouts.inscricao')

@section('title', 'Acesso ao Evento Negado')

@section('content')
    <div class="my-5">
        <div class="text-center">
            <div class="mb-4">
                <i class="bi bi-x-circle-fill text-danger" style="font-size: 3rem"></i>
            </div>
            <h2 class="card-title text-danger">Acesso Negado!</h2>
            <p class="lead mt-3">Ops!! Desculpe, o inscrito já acessou o evento ou não tem permissão de acesso!</p>
        </div>
    </div>
@endsection
