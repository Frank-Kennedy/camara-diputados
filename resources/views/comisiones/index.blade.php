@extends('layouts.app')

@section('title', 'Comisiones')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-parlamento-azul">🏛️ Comisiones</h1>
            <p class="text-gray-600 mt-1">Conoce las comisiones parlamentarias de la Cámara de Diputados</p>
        </div>
        <span class="bg-parlamento-azul text-white px-4 py-2 rounded-lg text-sm">
            Total: {{ $comisiones->total() }} comisiones
        </span>
    </div>

    <!-- Buscador -->
    <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
        <form method="GET" action="{{ route('comisiones.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="🔍 Buscar comisiones..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
            </div>
            <button type="submit" class="btn-primary">
                <i class="fas fa-search mr-1"></i> Buscar
            </button>
            @if(request('search'))
                <a href="{{ route('comisiones.index') }}" class="btn-secondary">
                    <i class="fas fa-times mr-1"></i> Limpiar
                </a>
            @endif
        </form>
    </div>

    @if($comisiones->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($comisiones as $comision)
                <div class="card hover:-translate-y-1 transition-all duration-300">
                    @if($comision->image)
                        <img src="{{ asset('storage/' . $comision->image) }}" 
                             alt="{{ $comision->name }}" 
                             class="w-full h-48 object-cover rounded-t-xl">
                    @else
                        <div class="w-full h-48 bg-gradient-to-r from-parlamento-azul to-parlamento-azul-claro rounded-t-xl flex items-center justify-center text-6xl text-white">
                            🏛️
                        </div>
                    @endif
                    <div class="p-4">
                        <h3 class="text-xl font-bold text-parlamento-azul mb-2">{{ $comision->name }}</h3>
                        <p class="text-gray-600 text-sm line-clamp-3">{{ $comision->description }}</p>
                        <div class="mt-3 flex items-center gap-2 text-sm text-gray-500">
                            <i class="fas fa-users"></i>
                            <span>{{ $comision->diputados_count }} diputados</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $comisiones->links() }}
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-xl shadow-lg">
            <div class="text-6xl mb-4">🏛️</div>
            <h3 class="text-2xl font-bold text-parlamento-azul mb-2">No hay comisiones registradas</h3>
            <p class="text-gray-500">Pronto se publicarán las comisiones parlamentarias.</p>
        </div>
    @endif
</div>

@push('styles')
<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endsection