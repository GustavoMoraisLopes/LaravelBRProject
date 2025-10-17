@extends('layouts.app')

@section('content')
<div class="flex justify-center mt-20">
    <form method="POST" action="{{ route('login') }}" class="bg-white p-8 rounded-lg shadow-lg w-96">
        @csrf
        <h2 class="text-2xl font-semibold text-center text-[#b41f1f] mb-6">Login</h2>

        <input type="email" name="email" placeholder="Email" class="w-full mb-4 p-2 border rounded" required>
        <input type="password" name="password" placeholder="Password" class="w-full mb-4 p-2 border rounded" required>

        <button type="submit"
            class="w-full bg-[#000000] text-white font-semibold py-2 rounded transition duration-200 hover:bg-[#8f1717] active:scale-95"> Entrar
        </button>


        <p class="mt-4 text-center text-sm">Ainda não tens conta?
            <a href="{{ route('register') }}" class="text-[#b41f1f] hover:underline">Regista-te</a>
        </p>
    </form>
</div>
@endsection
