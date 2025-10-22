@extends('layouts.app')

@section('content')
<div class="flex justify-center mt-20">
    <form method="POST" action="{{ route('register') }}" class="bg-white p-8 rounded-lg shadow-lg w-96">
        @csrf
        <div class="text-center mb-6">
            <i class="fa-solid fa-user-plus text-5xl text-red-700 mb-4"></i>
            <h2 class="text-2xl font-semibold text-[#b41f1f]">Criar Conta</h2>
        </div>

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold mb-2">
                <i class="fa-solid fa-user"></i> Nome
            </label>
            <input
                type="text"
                name="name"
                id="name"
                placeholder="O teu nome completo"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-700 focus:border-transparent"
                required
            >
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold mb-2">
                <i class="fa-solid fa-envelope"></i> Email
            </label>
            <input
                type="email"
                name="email"
                id="email"
                placeholder="o-teu-email@exemplo.com"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-700 focus:border-transparent"
                required
            >
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-semibold mb-2">
                <i class="fa-solid fa-lock"></i> Password
            </label>
            <input
                type="password"
                name="password"
                id="password"
                placeholder="••••••••"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-700 focus:border-transparent"
                required
            >
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">
                <i class="fa-solid fa-lock"></i> Confirmar Password
            </label>
            <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                placeholder="••••••••"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-700 focus:border-transparent"
                required
            >
        </div>

        <button type="submit"
            class="w-full bg-red-700 text-white font-semibold py-3 rounded-lg transition duration-200 hover:bg-red-800 active:scale-95">
            <i class="fa-solid fa-user-plus"></i> Criar Conta
        </button>

        <p class="mt-4 text-center text-sm">Já tens conta?
            <a href="{{ route('login') }}" class="text-[#b41f1f] hover:underline">
                <i class="fa-solid fa-right-to-bracket"></i> Inicia sessão
            </a>
        </p>
    </form>
</div>
@endsection
