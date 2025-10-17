@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-6">
    <h1 class="text-2xl font-bold text-red-700 mb-6">🛒 O teu carrinho</h1>

    @if(empty($carrinho))
        <p class="text-gray-600">Ainda não adicionaste nada ao carrinho.</p>
    @else
        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
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
                    <tr class="border-b">
                        <td class="py-3 px-4">{{ $item['nome'] }}</td>
                        <td class="py-3 px-4 text-center">{{ $item['quantidade'] }}</td>
                        <td class="py-3 px-4 text-center">{{ number_format($item['preco'], 2, ',', '.') }} €</td>
                        <td class="py-3 px-4 text-center">
                            <form action="{{ route('carrinho.remover', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-700 hover:text-red-900">❌</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
