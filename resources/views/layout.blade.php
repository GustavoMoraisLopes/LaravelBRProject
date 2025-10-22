<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuguinha - Produtos Tradicionais Portugueses</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('home') }}" class="logo">
            <i class="fa-solid fa-flag"></i> Tuguinha
        </a>
        <div class="menu">
            <a href="{{ route('home') }}">
                <i class="fa-solid fa-house"></i> Início
            </a>
            <a href="{{ route('produtos.index') }}">
                <i class="fa-solid fa-box"></i> Produtos
            </a>
            <a href="{{ route('carrinho.index') }}">
                <i class="fa-solid fa-cart-shopping"></i> Carrinho
            </a>
            @auth
                <a href="{{ route('logout') }}">
                    <i class="fa-solid fa-right-from-bracket"></i> Sair
                </a>
            @else
                <a href="{{ route('login') }}">
                    <i class="fa-solid fa-right-to-bracket"></i> Entrar
                </a>
                <a href="{{ route('register') }}">
                    <i class="fa-solid fa-user-plus"></i> Registar
                </a>
            @endauth
        </div>
    </nav>

    <main class="conteudo">
        @yield('content')
    </main>

    <footer class="footer">
        <p><i class="fa-solid fa-flag"></i> Tuguinha</p>
        <p>© {{ date('Y') }} Tuguinha. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
