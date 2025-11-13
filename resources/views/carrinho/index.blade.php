@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-6">
    <h1 class="text-2xl font-bold text-red-700 mb-6">
        <i class="fa-solid fa-cart-shopping"></i> O teu carrinho
    </h1>

    @if(empty($carrinho))
        <div class="bg-white p-8 rounded-lg shadow text-center dark:bg-gray-900 dark:text-gray-100">
            <i class="fa-solid fa-cart-shopping text-6xl text-gray-300 dark:text-gray-400 mb-4"></i>
            <p class="text-gray-600 dark:text-gray-300 text-lg">Ainda não adicionaste nada ao carrinho.</p>
            <a href="{{ route('produtos.index') }}" class="inline-block mt-4 bg-red-700 text-white px-6 py-2 rounded hover:bg-red-800 transition">
                <i class="fa-solid fa-box"></i> Ver Produtos
            </a>
        </div>
    @else
    <table class="w-full bg-white shadow-md rounded-lg overflow-hidden dark:bg-gray-900 dark:text-gray-100">
            <thead class="bg-red-700 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">Produto</th>
                    <th class="py-3 px-4 text-center">Qtd</th>
                    <th class="py-3 px-4 text-center">Preço</th>
                    <th class="py-3 px-4 text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carrinho as $id => $item)
                    <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <td class="py-3 px-4">{{ $item['nome'] }}</td>
                        <td class="py-3 px-4 text-center">{{ $item['quantidade'] }}</td>
                        <td class="py-3 px-4 text-center">{{ number_format($item['preco'], 2, ',', '.') }} €</td>
                        <td class="py-3 px-4 text-center">
                            <form action="{{ route('carrinho.remover', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-700 hover:text-red-900 transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 flex items-center justify-between">
            <div class="text-lg font-semibold">
                @php
                    $total = 0;
                    foreach ($carrinho as $item) { $total += $item['preco'] * $item['quantidade']; }
                @endphp
                Total: €{{ number_format($total, 2, ',', '.') }}
            </div>

            <div>
                <a href="{{ route('carrinho.checkout') }}" class="bg-primary text-white px-4 py-2 rounded hover:opacity-95">
                    <i class="fa-solid fa-credit-card"></i> Avançar para compra
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
