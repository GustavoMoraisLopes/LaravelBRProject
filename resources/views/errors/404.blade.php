@extends('layouts.app')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="text-center">
        <div class="mb-8">
            <i class="fa-solid fa-map-location-dot text-9xl text-red-700 mb-4"></i>
        </div>
        <h1 class="text-6xl font-bold text-gray-800 mb-4">404</h1>
        <h2 class="text-3xl font-semibold text-gray-700 mb-4">Página não encontrada</h2>
        <p class="text-gray-600 mb-8 max-w-md mx-auto">
            Oops! Parece que te perdeste. A página que procuras não existe ou foi removida.
        </p>
        <div class="flex gap-4 justify-center flex-wrap">
            <a href="{{ route('home') }}" class="bg-red-700 text-white px-6 py-3 rounded-lg hover:bg-red-800 transition font-semibold">
                <i class="fa-solid fa-house"></i> Voltar ao Início
            </a>
            <a href="{{ route('produtos.index') }}" class="bg-gray-700 text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition font-semibold">
                <i class="fa-solid fa-box"></i> Ver Produtos
            </a>
        </div>
    </div>
</div>
@endsection
