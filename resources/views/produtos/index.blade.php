@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-6">
    <h1 class="text-3xl font-bold text-center text-red-700 mb-6">🇵🇹 Bem-vindo à Tuguinha!</h1>
    <p class="text-center text-gray-600 mb-8">Descobre os melhores produtos tradicionais portugueses 🍷🧀🍞</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($produtos as $produto)
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                <img src="{{ $produto->imagem ?? 'https://via.placeholder.com/400x300' }}" alt="{{ $produto->nome }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $produto->nome }}</h2>
                    <p class="text-gray-600 mb-2">{{ $produto->descricao ?? 'Sem descrição disponível.' }}</p>
                    <p class="text-red-700 font-bold mb-4">{{ number_format($produto->preco, 2, ',', '.') }} €</p>
                    <form action="{{ route('carrinho.adicionar', $produto) }}" method="POST">
                        @csrf
                        <button class="w-full bg-red-700 text-white font-semibold py-2 rounded hover:bg-red-800 transition">
                            🛒 Adicionar ao Carrinho
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
