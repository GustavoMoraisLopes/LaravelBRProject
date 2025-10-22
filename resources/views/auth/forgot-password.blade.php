@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto py-12 px-6">
    <div class="bg-white shadow-xl rounded-lg p-8">
        <div class="text-center mb-6">
            <i class="fa-solid fa-key text-5xl text-red-700 mb-4"></i>
            <h1 class="text-2xl font-bold text-gray-800">Recuperar Password</h1>
            <p class="text-gray-600 mt-2">Esqueceste-te da tua password? Não te preocupes!</p>
        </div>

        @if (session('status'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                <i class="fa-solid fa-check-circle"></i> {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">
                    <i class="fa-solid fa-envelope"></i> Email
                </label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-700 focus:border-transparent"
                    placeholder="o-teu-email@exemplo.com"
                >
                @error('email')
                    <p class="text-red-600 text-sm mt-1">
                        <i class="fa-solid fa-exclamation-circle"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <button
                type="submit"
                class="w-full bg-red-700 text-white font-semibold py-3 rounded-lg hover:bg-red-800 transition"
            >
                <i class="fa-solid fa-paper-plane"></i> Enviar Link de Recuperação
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-red-700 hover:text-red-900 transition">
                <i class="fa-solid fa-arrow-left"></i> Voltar ao Login
            </a>
        </div>
    </div>
</div>
@endsection
