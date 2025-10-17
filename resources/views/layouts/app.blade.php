<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuguinha</title>

    <!-- TailwindCSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Config extra de cores (podes personalizar se quiseres) -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#b41f1f',
                        secondary: '#facc15',
                    }
                }
            }
        }
    </script>

    <!-- Fonte opcional -->
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;600&display=swap" rel="stylesheet">
</head>

<body class="font-[Figtree] bg-gray-100">
    <!-- NAVBAR -->
    <nav class="bg-primary text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="text-2xl font-semibold hover:text-secondary transition">
                    🇵🇹 Tuguinha
                </a>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="hover:text-secondary">Início</a>
                    <a href="{{ route('produtos.index') }}" class="hover:text-secondary">Produtos</a>
                    <a href="{{ route('carrinho.index') }}" class="hover:text-secondary">🛒</a>

                    @auth
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('backoffice') }}" class="hover:text-secondary">⚙️</a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="hover:text-secondary">👤</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-secondary">🚪</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-secondary">Entrar</a>
                        <a href="{{ route('register') }}" class="hover:text-secondary">Registar</a>
                    @endauth
                </div>

                <!-- Botão Mobile -->
                <button id="menu-btn" class="md:hidden text-2xl hover:text-secondary">☰</button>
            </div>
        </div>

        <!-- Menu Mobile -->
        <div id="mobile-menu" class="hidden bg-[#9e1a1a] md:hidden">
            <div class="flex flex-col items-center space-y-3 py-3">
                <a href="{{ route('home') }}" class="hover:text-secondary">Início</a>
                <a href="{{ route('produtos.index') }}" class="hover:text-secondary">Produtos</a>
                <a href="{{ route('carrinho.index') }}" class="hover:text-secondary">🛒 Carrinho</a>

                @auth
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('backoffice') }}" class="hover:text-secondary">⚙️ BackOffice</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="hover:text-secondary">👤 Perfil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="hover:text-secondary">🚪 Sair</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-secondary">Entrar</a>
                    <a href="{{ route('register') }}" class="hover:text-secondary">Registar</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Conteúdo -->
    <main class="max-w-7xl mx-auto py-8 px-4">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Script menu mobile -->
    <script>
        document.getElementById('menu-btn').addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>
