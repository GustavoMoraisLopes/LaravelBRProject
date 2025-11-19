<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuguinha - Produtos Tradicionais Portugueses</title>

    <!-- TailwindCSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Config extra de cores (podes personalizar se quiseres) -->
    <script>
        tailwind.config = {
            darkMode: 'class',
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

<body class="font-[Figtree] bg-gray-100 dark:bg-gray-900 flex flex-col min-h-screen transition-colors duration-300">
    <!-- NAVBAR -->
    @php
        $__carrinho = session('carrinho', []);
        $__cartCount = 0;
        if (!empty($__carrinho) && is_array($__carrinho)) {
            foreach ($__carrinho as $__it) {
                $__cartCount += intval($__it['quantidade'] ?? 0);
            }
        }
    @endphp
    <nav class="bg-primary dark:bg-gray-800 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="text-2xl font-semibold hover:text-secondary transition flex items-center gap-2">
                    <i class="fa-solid fa-flag"></i> Tuguinha
                </a>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="hover:text-secondary transition">
                        <i class="fa-solid fa-house"></i> Início
                    </a>
                    <a href="{{ route('produtos.index') }}" class="hover:text-secondary transition">
                        <i class="fa-solid fa-box"></i> Produtos
                    </a>
                    <a href="{{ route('carrinho.index') }}" class="hover:text-secondary transition relative">
                        <i class="fa-solid fa-cart-shopping"></i>
                        @if($__cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-secondary text-black text-xs font-semibold px-2 py-0.5 rounded-full">{{ $__cartCount }}</span>
                        @endif
                    </a>

                    <!-- Toggle Dark Mode - Desktop -->
                    <div class="flex items-center gap-2">
                        <label for="theme-toggle" class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="theme-toggle" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-600 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-secondary rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary"></div>
                            <i class="fa-solid fa-moon ml-2 text-sm" id="theme-label"></i>
                        </label>
                    </div>

                    @auth
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('backoffice') }}" class="hover:text-secondary transition">
                                <i class="fa-solid fa-gear"></i>
                            </a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="hover:text-secondary transition">
                            <i class="fa-solid fa-user"></i>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-secondary transition">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-secondary transition">
                            <i class="fa-solid fa-right-to-bracket"></i> Entrar
                        </a>
                        <a href="{{ route('register') }}" class="hover:text-secondary transition">
                            <i class="fa-solid fa-user-plus"></i> Registar
                        </a>
                    @endauth
                </div>

                <!-- Botão Mobile -->
                <div class="md:hidden flex items-center gap-3">
                    <label for="theme-toggle-mobile" class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="theme-toggle-mobile" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-secondary rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary"></div>
                    </label>
                    <button id="menu-btn" class="text-2xl hover:text-secondary">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu Mobile -->
        <div id="mobile-menu" class="hidden bg-[#9e1a1a] md:hidden">
            <div class="flex flex-col items-center space-y-3 py-3">
                <a href="{{ route('home') }}" class="hover:text-secondary transition">
                    <i class="fa-solid fa-house"></i> Início
                </a>
                <a href="{{ route('produtos.index') }}" class="hover:text-secondary transition">
                    <i class="fa-solid fa-box"></i> Produtos
                </a>
                <a href="{{ route('carrinho.index') }}" class="hover:text-secondary transition">
                    <i class="fa-solid fa-cart-shopping"></i> Carrinho
                    @if($__cartCount > 0)
                        <span class="ml-2 inline-block bg-secondary text-black text-xs font-semibold px-2 py-0.5 rounded-full">{{ $__cartCount }}</span>
                    @endif
                </a>

                @auth
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('backoffice') }}" class="hover:text-secondary transition">
                            <i class="fa-solid fa-gear"></i> BackOffice
                        </a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="hover:text-secondary transition">
                        <i class="fa-solid fa-user"></i> Perfil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="hover:text-secondary transition">
                            <i class="fa-solid fa-right-from-bracket"></i> Sair
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-secondary transition">
                        <i class="fa-solid fa-right-to-bracket"></i> Entrar
                    </a>
                    <a href="{{ route('register') }}" class="hover:text-secondary transition">
                        <i class="fa-solid fa-user-plus"></i> Registar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Conteúdo -->
    <main class="flex-grow max-w-7xl mx-auto py-8 px-4 w-full">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 dark:bg-gray-950 text-white mt-auto">
        <div class="max-w-7xl mx-auto py-8 px-4">
            <div class="text-center">
                <p class="text-lg font-semibold mb-2">
                    <i class="fa-solid fa-flag"></i> Tuguinha
                </p>
                <p class="text-sm text-gray-400">
                    © {{ date('Y') }} Tuguinha. Todos os direitos reservados.
                </p>
                <div class="flex justify-center gap-4 mt-4">
                    <a href="#" class="hover:text-secondary transition">
                        <i class="fa-brands fa-facebook fa-lg"></i>
                    </a>
                    <a href="#" class="hover:text-secondary transition">
                        <i class="fa-brands fa-instagram fa-lg"></i>
                    </a>
                    <a href="#" class="hover:text-secondary transition">
                        <i class="fa-brands fa-twitter fa-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Menu Mobile
        document.getElementById('menu-btn').addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // Dark Mode Toggle
        const themeToggle = document.getElementById('theme-toggle');
        const themeToggleMobile = document.getElementById('theme-toggle-mobile');
        const themeLabel = document.getElementById('theme-label');
        const html = document.documentElement;

        // Verificar preferência salva
        const currentTheme = localStorage.getItem('theme') || 'light';
        if (currentTheme === 'dark') {
            html.classList.add('dark');
            themeToggle.checked = true;
            themeToggleMobile.checked = true;
            updateLabel(true);
        }

        function updateLabel(isDark) {
            if (themeLabel) {
                if (isDark) {
                    themeLabel.classList.remove('fa-moon');
                    themeLabel.classList.add('fa-sun');
                } else {
                    themeLabel.classList.remove('fa-sun');
                    themeLabel.classList.add('fa-moon');
                }
            }
        }

        function toggleTheme() {
            const isDark = html.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            themeToggle.checked = isDark;
            themeToggleMobile.checked = isDark;
            updateLabel(isDark);
        }

        themeToggle.addEventListener('change', toggleTheme);
        themeToggleMobile.addEventListener('change', toggleTheme);
    </script>
    @stack('scripts')
</body>
</html>
