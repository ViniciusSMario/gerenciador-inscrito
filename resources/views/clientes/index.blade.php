@extends('app', ['activePage' => 'clientes', 'titlePage' => 'Clientes'])
@section('title', 'Clientes')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
           
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible text-white fade show" role="alert">
                    <strong><i class="bi bi-exclamation-triangle-fill"></i> Ops! Algo deu errado.</strong>
                    <ul class="mt-2 mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Exibição de Mensagem de Sucesso -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible text-white fade show" role="alert">
                    <strong><i class="bi bi-check-circle-fill"></i> Sucesso!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('clientes.create') }}" class="btn btn-sm btn-success">
                            Adicionar Cliente
                        </a>
                    </div>
                    <div class="table-responsive">

                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Telefone</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($clientes) <= 0)
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            Não há clientes cadastrados
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($clientes as $cliente)
                                        <tr>
                                            <td>{{ $cliente->id }}</td>
                                            <td>{{ $cliente->nome }}</td>
                                            <td>{{ $cliente->email }}</td>
                                            <td>{{ $cliente->telefone }}</td>
                                            <td>
                                                <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-sm btn-primary">
                                                    <i class="material-icons icon-button">visibility</i>
                                                </a>
                                                <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-warning">
                                                    <i class="material-icons icon-button">edit</i>
                                                </a>
                                                <form action="{{ route('clientes.destroy', $cliente) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Deseja excluir este cliente?')">
                                                        <i class="material-icons icon-button">delete</i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $clientes->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
