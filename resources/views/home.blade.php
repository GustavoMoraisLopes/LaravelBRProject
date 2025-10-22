@extends('layouts.app')

@section('content')
<div class="py-12">
    <!-- Hero Section -->
    <div class="text-center mb-12 fade-in">
        <h1 class="text-5xl font-bold text-gray-800 dark:text-gray-100 mb-4">
            <i class="fa-solid fa-flag text-red-700"></i> Bem-vindo à Tuguinha!
        </h1>
        <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
            Os melhores produtos tradicionais portugueses estão aqui!
        </p>
    </div>

    <!-- Features Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto mb-12">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 text-center">
            <i class="fa-solid fa-wine-bottle text-5xl text-red-700 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">Vinhos Tradicionais</h3>
            <p class="text-gray-600 dark:text-gray-300">Descobre os melhores vinhos portugueses</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 text-center">
            <i class="fa-solid fa-cheese text-5xl text-red-700 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">Queijos Artesanais</h3>
            <p class="text-gray-600 dark:text-gray-300">Saboreia os queijos mais autênticos</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 text-center">
            <i class="fa-solid fa-bread-slice text-5xl text-red-700 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">Pão Tradicional</h3>
            <p class="text-gray-600 dark:text-gray-300">O melhor pão caseiro português</p>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="text-center">
        <a href="{{ route('produtos.index') }}" class="inline-block bg-red-700 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-red-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
            <i class="fa-solid fa-shopping-bag"></i> Ver Todos os Produtos
        </a>
    </div>
</div>
@endsection
