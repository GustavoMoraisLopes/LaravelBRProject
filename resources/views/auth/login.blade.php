@extends('layouts.app')

@section('content')
<div class="flex justify-center mt-8">
    @if(session('info'))
        <div id="login-flash" role="alert" aria-live="assertive" class="max-w-2xl w-full bg-yellow-100 border-l-4 border-yellow-400 text-yellow-800 p-4 mb-6 rounded shadow">
            <div class="flex items-start">
                <div class="flex-1">
                    <strong class="font-semibold">Aviso:</strong>
                    <p class="mt-1">{{ session('info') }}</p>
                </div>
                <button aria-label="Fechar" onclick="document.getElementById('login-flash').style.display='none'" class="ml-4 text-yellow-800 hover:text-yellow-900">✖</button>
            </div>
        </div>
        <script>
            try { alert(@json(session('info'))); } catch(e){}
        </script>
    @endif

    <form method="POST" action="{{ route('login') }}" class="bg-white p-8 rounded-lg shadow-lg w-96">
        @csrf
        <div class="text-center mb-6">
            <i class="fa-solid fa-right-to-bracket text-5xl text-red-700 mb-4"></i>
            <h2 class="text-2xl font-semibold text-[#b41f1f]">Login</h2>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 p-3 mb-4 rounded">
                <div class="font-semibold">Erro de autenticação</div>
                <ul class="list-disc pl-5 mt-2 text-sm">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('info'))
            <div class="bg-yellow-100 border-l-4 border-yellow-400 text-yellow-800 p-3 mb-4 rounded">
                {{ session('info') }}
            </div>
            <script>

                try {
                    alert(@json(session('info')));
                } catch (e) {
                }
            </script>
        @endif

        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold mb-2">
                <i class="fa-solid fa-envelope"></i> Email
            </label>
            <input
                type="email"
                name="email"
                id="email"
                placeholder="o-teu-email@exemplo.com"
                value="{{ old('email') }}"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-700 focus:border-transparent"
                required
            >
            @error('email')
                <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
            @enderror
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
            @error('password')
                <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
            @enderror
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
