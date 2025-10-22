@extends('layouts.app')

@section('content')
<div class="flex justify-center mt-20">
    <form method="POST" action="{{ route('login') }}" class="bg-white p-8 rounded-lg shadow-lg w-96">
        @csrf
        <div class="text-center mb-6">
            <i class="fa-solid fa-right-to-bracket text-5xl text-red-700 mb-4"></i>
            <h2 class="text-2xl font-semibold text-[#b41f1f]">Login</h2>
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

        <div class="mb-6 text-right">
            <a href="{{ route('password.request') }}" class="text-sm text-red-700 hover:text-red-900 transition">
                <i class="fa-solid fa-key"></i> Esqueceste-te da password?
            </a>
        </div>

        <button type="submit"
            class="w-full bg-red-700 text-white font-semibold py-3 rounded-lg transition duration-200 hover:bg-red-800 active:scale-95">
            <i class="fa-solid fa-right-to-bracket"></i> Entrar
        </button>

        <p class="mt-4 text-center text-sm">Ainda não tens conta?
            <a href="{{ route('register') }}" class="text-[#b41f1f] hover:underline">
                <i class="fa-solid fa-user-plus"></i> Regista-te
            </a>
        </p>
    </form>
</div>
@endsection
