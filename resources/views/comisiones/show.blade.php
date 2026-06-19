@extends('layouts.app')

@section('title', $comision->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Migas de pan -->
    <nav class="text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-parlamento-azul">Inicio</a>
        <span class="mx-2">›</span>
        <a href="{{ route('comisiones.index') }}" class="hover:text-parlamento-azul">Comisiones</a>
        <span class="mx-2">›</span>
        <span class="text-parlamento-azul font-medium">{{ $comision->name }}</span>
    </nav>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="md:flex">
            <!-- Columna izquierda - Imagen e info -->
            <div class="md:w-1/3">
                @if($comision->image)
                    <img src="{{ asset('storage/' . $comision->image) }}" 
                         alt="{{ $comision->name }}" 
                         class="w-full h-64 md:h-full object-cover">
                @else
                    <div class="w-full h-64 md:h-full bg-gradient-to-br from-parlamento-azul to-parlamento-azul-claro flex items-center justify-center text-8xl text-white">
                        🏛️
                    </div>
                @endif
            </div>

            <!-- Columna derecha - Información -->
            <div class="md:w-2/3 p-8">
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-parlamento-azul">{{ $comision->name }}</h1>
                        <div class="mt-2">
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-bold 
                                {{ $comision->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $comision->is_active ? '✅ Activa' : '❌ Inactiva' }}
                            </span>
                            <span class="ml-2 inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-users mr-1"></i> {{ $comision->diputados_count }} diputados
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="mt-6">
                    <h2 class="text-xl font-bold text-parlamento-azul mb-3">📋 Descripción</h2>
                    <div class="bg-gray-50 rounded-xl p-4 text-gray-700 leading-relaxed">
                        {{ $comision->description }}
                    </div>
                </div>

                <!-- Diputados miembros -->
                @if($comision->diputados->count() > 0)
                    <div class="mt-8">
                        <h2 class="text-xl font-bold text-parlamento-azul mb-4">👤 Diputados Miembros</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($comision->diputados as $diputado)
                                <a href="{{ route('diputados.show', $diputado->id) }}" 
                                   class="bg-gray-50 rounded-xl p-4 hover:shadow-md transition hover:-translate-y-1">
                                    <div class="flex items-center gap-3">
                                        @if($diputado->photo)
                                            <img src="{{ asset('storage/' . $diputado->photo) }}" 
                                                 alt="{{ $diputado->full_name }}" 
                                                 class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-xl">
                                                👤
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-bold text-parlamento-azul text-sm">{{ $diputado->full_name }}</p>
                                            @if($diputado->pivot->role)
                                                <p class="text-xs text-gray-500">{{ $diputado->pivot->role }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Botones -->
                <div class="mt-8 pt-6 border-t border-gray-200 flex flex-wrap gap-3">
                    <a href="{{ route('comisiones.index') }}" class="btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i> Volver a Comisiones
                    </a>
                    
                    @auth
                        @if(auth()->user()->isAdmin() || auth()->user()->isEditor())
                            <a href="{{ route('admin.comisiones.edit', $comision->id) }}" 
                               class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                                <i class="fas fa-edit mr-2"></i> Editar
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection