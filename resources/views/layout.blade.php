<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuguinha</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('home') }}" class="logo">🇵🇹 Tuguinha</a>
        <div class="menu">
            <a href="{{ route('home') }}">Início</a>
            <a href="{{ route('produtos.index') }}">Produtos</a>
            <a href="{{ route('carrinho.index') }}">Carrinho 🛒</a>
            @auth
                <a href="{{ route('logout') }}">Sair 🚪</a>
            @else
                <a href="{{ route('login') }}">Entrar</a>
                <a href="{{ route('register') }}">Registar</a>
            @endauth
        </div>
    </nav>

    <main class="conteudo">
        @yield('content')
    </main>

    <footer class="footer">
        <p>© 2025 Tuguinha. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
