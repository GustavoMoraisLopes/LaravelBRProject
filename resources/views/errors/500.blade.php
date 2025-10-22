@extends('layouts.app')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="text-center">
        <div class="mb-8">
            <i class="fa-solid fa-triangle-exclamation text-9xl text-red-700 mb-4"></i>
        </div>
        <h1 class="text-6xl font-bold text-gray-800 mb-4">500</h1>
        <h2 class="text-3xl font-semibold text-gray-700 mb-4">Erro Interno do Servidor</h2>
        <p class="text-gray-600 mb-8 max-w-md mx-auto">
            Algo correu mal do nosso lado. Estamos a trabalhar para resolver o problema.
        </p>
        <div class="flex gap-4 justify-center flex-wrap">
            <a href="{{ route('home') }}" class="bg-red-700 text-white px-6 py-3 rounded-lg hover:bg-red-800 transition font-semibold">
                <i class="fa-solid fa-house"></i> Voltar ao Início
            </a>
        </div>
    </div>
</div>
@endsection
