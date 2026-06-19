<header class="bg-parlamento-azul text-white shadow-lg sticky top-0 z-50">
    <nav class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center space-x-4">
                <div class="bg-white w-12 h-12 rounded-full flex items-center justify-center text-2xl font-bold text-parlamento-azul" >
<!-- style="background-image: url('{{ asset('images/escudo-gq.jpeg') }}'); background-size: cover; background-position: center; background-attachment: fixed;"-->
                    <img src="../images/escudo-gq.png" alt="GQ">
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold">Cámara de Diputados</h1>
                    <p class="text-xs md:text-sm text-gray-300">Guinea Ecuatorial</p>
                </div>
            </div>
            
            <!-- Menú desktop -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('home') }}" class="hover:text-parlamento-oro transition">Inicio</a>
                <a href="{{ route('diputados.index') }}" class="hover:text-parlamento-oro transition">Diputados</a>
                <a href="{{ route('comisiones.index') }}" class="hover:text-parlamento-oro transition">Comisiones</a>
                <a href="{{ route('leyes.index') }}" class="hover:text-parlamento-oro transition">Legislativo</a>
                <a href="{{ route('noticias.index') }}" class="hover:text-parlamento-oro transition">Noticias</a>
                <a href="{{ route('transparencia.index') }}" class="hover:text-parlamento-oro transition">Transparencia</a>
                
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.users.index') }}" class="hover:text-parlamento-oro transition">
                            👥 Usuarios
                        </a>
                    @endif
                @endauth
            </div>
            
            <!-- Botones de usuario -->
            <div class="flex items-center space-x-4">
                @auth
                    <span class="hidden md:inline text-sm">{{ Auth::user()->full_name ?? Auth::user()->name }}</span>
                    <a href="{{ route('dashboard') }}" class="bg-parlamento-oro text-parlamento-azul px-4 py-2 rounded-lg hover:bg-parlamento-oro-claro transition font-medium text-sm">
                        📊 Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600 transition text-sm">
                            Salir
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="border-2 border-white px-4 py-2 rounded-lg hover:bg-white hover:text-parlamento-azul transition text-sm hidden md:inline">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="bg-parlamento-oro text-parlamento-azul px-4 py-2 rounded-lg hover:bg-parlamento-oro-claro transition font-medium text-sm hidden md:inline">
                        Registrarse
                    </a>
                @endauth
                
                <!-- Botón menú hamburguesa (móvil) -->
                <button id="menu-toggle" class="md:hidden text-white text-2xl focus:outline-none">
                    ☰
                </button>
            </div>
        </div>
        
        <!-- Menú móvil -->
        <div id="mobile-menu" class="hidden md:hidden mt-4 pt-4 border-t border-gray-700">
            <div class="flex flex-col space-y-3">
                <a href="{{ route('home') }}" class="hover:text-parlamento-oro transition py-2 px-4 hover:bg-white/10 rounded">Inicio</a>
                <a href="{{ route('diputados.index') }}" class="hover:text-parlamento-oro transition py-2 px-4 hover:bg-white/10 rounded">Diputados</a>
                <a href="{{ route('comisiones.index') }}" class="hover:text-parlamento-oro transition py-2 px-4 hover:bg-white/10 rounded">Comisiones</a>
                <a href="{{ route('leyes.index') }}" class="hover:text-parlamento-oro transition py-2 px-4 hover:bg-white/10 rounded">Legislativo</a>
                <a href="{{ route('noticias.index') }}" class="hover:text-parlamento-oro transition py-2 px-4 hover:bg-white/10 rounded">Noticias</a>
                <a href="{{ route('transparencia.index') }}" class="hover:text-parlamento-oro transition py-2 px-4 hover:bg-white/10 rounded">Transparencia</a>
                
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.users.index') }}" class="hover:text-parlamento-oro transition py-2 px-4 hover:bg-white/10 rounded">
                            👥 Usuarios
                        </a>
                    @endif
                    <a href="{{ route('dashboard') }}" class="bg-parlamento-oro text-parlamento-azul px-4 py-2 rounded-lg hover:bg-parlamento-oro-claro transition font-medium text-center">
                        📊 Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="text-center">
                        @csrf
                        <button type="submit" class="bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600 transition w-full">
                            Salir
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="border-2 border-white px-4 py-2 rounded-lg hover:bg-white hover:text-parlamento-azul transition text-center">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="bg-parlamento-oro text-parlamento-azul px-4 py-2 rounded-lg hover:bg-parlamento-oro-claro transition font-medium text-center">
                        Registrarse
                    </a>
                @endauth
            </div>
        </div>
    </nav>
</header>

<script>
    // Toggle menú móvil
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (menuToggle && mobileMenu) {
            menuToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }
    });
</script>