@extends('layouts.app')

@section('content')
<div class="flex justify-center mt-20">
    <form method="POST" action="{{ route('register') }}" class="bg-white p-8 rounded-lg shadow-lg w-96">
        @csrf
        <h2 class="text-2xl font-semibold text-center text-[#b41f1f] mb-6">Registar</h2>

        <input type="text" name="name" placeholder="Nome" class="w-full mb-4 p-2 border rounded" required>
        <input type="email" name="email" placeholder="Email" class="w-full mb-4 p-2 border rounded" required>
        <input type="password" name="password" placeholder="Password" class="w-full mb-4 p-2 border rounded" required>
        <input type="password" name="password_confirmation" placeholder="Confirmar Password" class="w-full mb-4 p-2 border rounded" required>

        <button type="submit"
        class="w-full bg-[#000000] text-white font-semibold py-2 rounded transition duration-200 hover:bg-[#8f1717] active:scale-95">Criar Conta
        </button>


        <p class="mt-4 text-center text-sm">Já tens conta?
            <a href="{{ route('login') }}" class="text-[#b41f1f] hover:underline">Inicia sessão</a>
        </p>
    </form>
</div>
@endsection
