@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto py-12 px-6">
    <div class="bg-white shadow-xl rounded-lg p-8">
        <div class="text-center mb-6">
            <i class="fa-solid fa-lock-open text-5xl text-red-700 mb-4"></i>
            <h1 class="text-2xl font-bold text-gray-800">Redefinir Password</h1>
            <p class="text-gray-600 mt-2">Escolhe uma nova password segura</p>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">
                    <i class="fa-solid fa-envelope"></i> Email
                </label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    required
                    autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-700 focus:border-transparent"
                >
                @error('email')
                    <p class="text-red-600 text-sm mt-1">
                        <i class="fa-solid fa-exclamation-circle"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold mb-2">
                    <i class="fa-solid fa-lock"></i> Nova Password
                </label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-700 focus:border-transparent"
                >
                @error('password')
                    <p class="text-red-600 text-sm mt-1">
                        <i class="fa-solid fa-exclamation-circle"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">
                    <i class="fa-solid fa-lock"></i> Confirmar Password
                </label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-700 focus:border-transparent"
                >
            </div>

            <button
                type="submit"
                class="w-full bg-red-700 text-white font-semibold py-3 rounded-lg hover:bg-red-800 transition"
            >
                <i class="fa-solid fa-check"></i> Redefinir Password
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
