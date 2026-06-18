@extends('layouts.app')

@section('title', 'Registrarse')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8"
     style="background-image: url('{{ asset('images/parlamento-bg2.jpeg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
    
    <div class="absolute inset-0 bg-parlamento-azul opacity-75"></div>
    
    <div class="relative z-10 w-full max-w-md">
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl p-8">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full mb-4">
                    <!--<span class="text-4xl font-bold text-parlamento-azul">CD</span>-->
                    <img src="images/escudo-gq.png" alt="Escudo">
                </div>
                <h2 class="text-3xl font-bold text-parlamento-azul">Crear Cuenta</h2>
                <p class="text-gray-600 mt-1">Cámara de Diputados de Guinea Ecuatorial</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="grid grid-cols-2 gap-3">
                    <div class="mb-3">
                        <label for="name" class="block text-gray-700 font-medium mb-1 text-sm">Nombre</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul focus:ring-2 focus:ring-parlamento-azul/20 transition">
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="block text-gray-700 font-medium mb-1 text-sm">Apellido</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul focus:ring-2 focus:ring-parlamento-azul/20 transition">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="block text-gray-700 font-medium mb-1 text-sm">Correo Electrónico</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul focus:ring-2 focus:ring-parlamento-azul/20 transition">
                </div>

                <div class="mb-3">
                    <label for="password" class="block text-gray-700 font-medium mb-1 text-sm">Contraseña</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul focus:ring-2 focus:ring-parlamento-azul/20 transition">
                    <p class="text-xs text-gray-500 mt-1">Mínimo 8 caracteres</p>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700 font-medium mb-1 text-sm">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul focus:ring-2 focus:ring-parlamento-azul/20 transition">
                </div>

                <button type="submit"
                    class="w-full bg-parlamento-oro text-parlamento-azul py-3 rounded-lg hover:bg-parlamento-oro-claro transition duration-300 font-medium text-lg shadow-lg hover:shadow-xl">
                    <i class="fas fa-user-plus mr-2"></i> Registrarse
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    ¿Ya tienes cuenta? 
                    <a href="{{ route('login') }}" class="text-parlamento-azul font-bold hover:underline">
                        Inicia Sesión aquí
                    </a>
                </p>
            </div>

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
@endsection