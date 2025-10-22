@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8 px-4">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-3xl font-bold text-red-700 mb-6">
            <i class="fa-solid fa-gear"></i> Backoffice
        </h1>

        <a href="{{ route('backoffice.create') }}" class="inline-block bg-red-700 text-white px-6 py-3 rounded-lg hover:bg-red-800 transition mb-6">
            <i class="fa-solid fa-plus"></i> Adicionar Produto
        </a>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <h3 class="text-2xl font-semibold text-gray-800 mb-4">
            <i class="fa-solid fa-box"></i> Produtos
        </h3>
        <div class="overflow-x-auto mb-8">
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-red-700 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">Nome</th>
                        <th class="py-3 px-4 text-left">Descrição</th>
                        <th class="py-3 px-4 text-center">Preço</th>
                        <th class="py-3 px-4 text-center">Imagem</th>
                        <th class="py-3 px-4 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produtos as $produto)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-3 px-4">{{ $produto->nome }}</td>
                            <td class="py-3 px-4">{{ $produto->descricao }}</td>
                            <td class="py-3 px-4 text-center font-semibold">{{ $produto->preco }} €</td>
                            <td class="py-3 px-4 text-center">
                                @if($produto->imagem)
                                    <img src="{{ asset('storage/' . $produto->imagem) }}" width="80" class="rounded mx-auto">
                                @else
                                    <i class="fa-solid fa-image text-gray-300 text-2xl"></i>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center">
                                <form method="POST" action="{{ route('produtos.destroy', $produto) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                                        <i class="fa-solid fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h3 class="text-2xl font-semibold text-gray-800 mb-4">
            <i class="fa-solid fa-users"></i> Utilizadores
        </h3>
        <div class="overflow-x-auto">
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-700 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">
                            <i class="fa-solid fa-user"></i> Nome
                        </th>
                        <th class="py-3 px-4 text-left">
                            <i class="fa-solid fa-envelope"></i> Email
                        </th>
                        <th class="py-3 px-4 text-center">
                            <i class="fa-solid fa-shield-halved"></i> Tipo
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($utilizadores as $user)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-3 px-4">{{ $user->name }}</td>
                            <td class="py-3 px-4">{{ $user->email }}</td>
                            <td class="py-3 px-4 text-center">
                                @if($user->is_admin)
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">
                                        <i class="fa-solid fa-crown"></i> Admin
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-semibold">
                                        <i class="fa-solid fa-user"></i> Comum
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
