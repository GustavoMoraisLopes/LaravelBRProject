@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Backoffice</h1>

    <a href="{{ route('backoffice.create') }}" class="btn btn-primary mb-3">Adicionar Produto</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h3>Produtos</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Imagem</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produtos as $produto)
                <tr>
                    <td>{{ $produto->nome }}</td>
                    <td>{{ $produto->descricao }}</td>
                    <td>{{ $produto->preco }} €</td>
                    <td>
                        @if($produto->imagem)
                            <img src="{{ asset('storage/' . $produto->imagem) }}" width="80">
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('produtos.destroy', $produto) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="mt-5">Utilizadores</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($utilizadores as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->is_admin ? 'Admin' : 'Comum' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
