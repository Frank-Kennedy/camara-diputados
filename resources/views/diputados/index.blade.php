@extends('layouts.app')

@section('title', 'Diputados')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-parlamento-azul">Diputados</h1>
            <p class="text-gray-600 mt-1">Conoce a tus representantes en la Cámara de Diputados</p>
        </div>
        <div>
            <span class="bg-parlamento-azul text-white px-4 py-2 rounded-lg text-sm">
                Total: {{ $diputados->total() }} diputados
            </span>
        </div>
    </div>
    
    @if($diputados->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($diputados as $diputado)
                <div class="card text-center hover:-translate-y-1 transition-all duration-300">
                    <!-- Foto -->
                    @if($diputado->photo)
                        <img src="{{ asset('storage/' . $diputado->photo) }}" 
                             alt="{{ $diputado->full_name }}" 
                             class="w-28 h-28 rounded-full mx-auto mb-4 object-cover border-4 border-parlamento-oro">
                    @else
                        <div class="w-28 h-28 rounded-full mx-auto mb-4 bg-gray-200 flex items-center justify-center text-5xl border-4 border-parlamento-oro">
                            👤
                        </div>
                    @endif
                    
                    <!-- Nombre -->
                    <h3 class="text-xl font-bold text-parlamento-azul">
                        {{ $diputado->full_name }}
                    </h3>
                    
                    <!-- Partido -->
                    <p class="text-gray-600 text-sm font-medium">
                        {{ $diputado->political_party }}
                    </p>
                    
                    <!-- Circunscripción -->
                    <p class="text-gray-500 text-sm">
                        📍 {{ $diputado->constituency }}
                    </p>
                    
                    <!-- Cargo -->
                    @if($diputado->position)
                        <span class="inline-block bg-parlamento-oro text-white text-xs px-3 py-1 rounded-full mt-2">
                            {{ $diputado->position }}
                        </span>
                    @endif
                    
                    <!-- Botón Ver Perfil -->
                    <a href="{{ route('diputados.show', $diputado->id) }}" 
                       class="btn-primary inline-block mt-4 text-sm w-full">
                        Ver perfil
                    </a>
                </div>
            @endforeach
        </div>
        
        <!-- Paginación -->
        <div class="mt-8">
            {{ $diputados->links() }}
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-xl shadow-lg">
            <div class="text-6xl mb-4">👤</div>
            <h3 class="text-2xl font-bold text-parlamento-azul mb-2">No hay diputados registrados</h3>
            <p class="text-gray-500">Pronto se agregarán los perfiles de los diputados.</p>
        </div>
    @endif
</div>
@endsection