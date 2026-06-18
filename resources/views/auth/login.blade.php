@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8"
     style="background-image: url('{{ asset('images/parlamento-bg1.jpeg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
    
    <!-- Overlay para oscurecer el fondo y mejorar legibilidad -->
    <div class="absolute inset-0 bg-parlamento-azul opacity-75"></div>
    
    <div class="relative z-10 w-full max-w-md">
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl p-8">
            <!-- Logo o icono -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full mb-4">
                    <!--<span class="text-4xl font-bold text-parlamento-azul">CD</span>-->
                    <img src="images/escudo-gq.png" alt="Escudo">
                </div>
                <h2 class="text-3xl font-bold text-parlamento-azul">Iniciar Sesión</h2>
                <p class="text-gray-600 mt-1">Cámara de Diputados de Guinea Ecuatorial</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-envelope mr-2"></i> Correo Electrónico
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        placeholder="ejemplo@parlamentoge.qq"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul focus:ring-2 focus:ring-parlamento-azul/20 transition">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-lock mr-2"></i> Contraseña
                    </label>
                    <input type="password" name="password" id="password" required
                        placeholder="••••••••"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul focus:ring-2 focus:ring-parlamento-azul/20 transition">
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center text-sm text-gray-600">
                        <input type="checkbox" name="remember" class="mr-2 rounded border-gray-300 text-parlamento-azul focus:ring-parlamento-azul">
                        Recordarme
                    </label>
                    <a href="#" class="text-sm text-parlamento-azul hover:underline">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>

                <button type="submit"
                    class="w-full bg-parlamento-azul text-white py-3 rounded-lg hover:bg-parlamento-azul-claro transition duration-300 font-medium text-lg shadow-lg hover:shadow-xl">
                    <i class="fas fa-sign-in-alt mr-2"></i> Iniciar Sesión
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    ¿No tienes cuenta? 
                    <a href="{{ route('register') }}" class="text-parlamento-azul font-bold hover:underline">
                        Regístrate aquí
                    </a>
                </p>
            </div>

            <!-- Información adicional -->
            <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                <p class="text-xs text-gray-500">
                    <i class="fas fa-shield-alt mr-1"></i> 
                    Tus datos están seguros y protegidos
                </p>
                <p class="text-xs text-gray-400 mt-1">
                    © {{ date('Y') }} Cámara de Diputados - Guinea Ecuatorial
                </p>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Asegurar que el fondo cubra toda la pantalla */
    .min-h-screen {
        min-height: 100vh;
        min-height: 100dvh;
    }
    /* Efecto de vidrio para el formulario */
    .backdrop-blur-sm {
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    /* Transición suave para los inputs */
    input:focus {
        transition: all 0.3s ease;
    }
</style>
@endpush
@endsection