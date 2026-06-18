@extends('layouts.app')

@section('title', 'Noticias')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-parlamento-azul">📰 Noticias</h1>
            <p class="text-gray-600 mt-1">Mantente informado con las últimas noticias de la Cámara de Diputados</p>
        </div>
        @auth
            @if(auth()->user()->isAdmin() || auth()->user()->isEditor())
                <a href="{{ route('admin.noticias.create') }}" class="btn-primary">
                    + Crear Noticia
                </a>
            @endif
        @endauth
    </div>

    <!-- Noticias Destacadas -->
    @if(isset($destacadas) && $destacadas->count() > 0)
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-parlamento-azul mb-4">⭐ Destacadas</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($destacadas as $destacada)
                    <div class="card hover:-translate-y-1 transition-all duration-300">
                        @if($destacada->featured_image)
                            <img src="{{ asset('storage/' . $destacada->featured_image) }}" 
                                 alt="{{ $destacada->title }}" 
                                 class="w-full h-48 object-cover rounded-t-xl">
                        @else
                            <div class="w-full h-48 bg-gradient-to-r from-parlamento-azul to-parlamento-azul-claro rounded-t-xl flex items-center justify-center text-6xl text-white">
                                📰
                            </div>
                        @endif
                        <div class="p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs font-bold text-white bg-parlamento-azul px-2 py-1 rounded">
                                    {{ $destacada->category_label }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    {{ $destacada->published_date->format('d/m/Y') }}
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-parlamento-azul mb-2 line-clamp-2">
                                {{ $destacada->title }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ $destacada->summary }}
                            </p>
                            <a href="{{ route('noticias.show', $destacada->slug) }}" 
                               class="btn-primary text-sm inline-block">
                                Leer más →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Lista de noticias -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($noticias as $noticia)
            <div class="card hover:-translate-y-1 transition-all duration-300">
                @if($noticia->featured_image)
                    <img src="{{ asset('storage/' . $noticia->featured_image) }}" 
                         alt="{{ $noticia->title }}" 
                         class="w-full h-48 object-cover rounded-t-xl">
                @else
                    <div class="w-full h-48 bg-gradient-to-r from-gray-200 to-gray-300 rounded-t-xl flex items-center justify-center text-6xl">
                        📰
                    </div>
                @endif
                <div class="p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs font-bold text-white bg-parlamento-azul px-2 py-1 rounded">
                            {{ $noticia->category_label }}
                        </span>
                        <span class="text-xs text-gray-500">
                            {{ $noticia->published_date->format('d/m/Y') }}
                        </span>
                        @if($noticia->is_featured)
                            <span class="text-xs">⭐</span>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold text-parlamento-azul mb-2 line-clamp-2">
                        {{ $noticia->title }}
                    </h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                        {{ $noticia->summary }}
                    </p>
                    <a href="{{ route('noticias.show', $noticia->slug) }}" 
                       class="btn-primary text-sm inline-block">
                        Leer más →
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16 bg-white rounded-xl shadow-lg">
                <div class="text-6xl mb-4">📰</div>
                <h3 class="text-2xl font-bold text-parlamento-azul mb-2">No hay noticias disponibles</h3>
                <p class="text-gray-500">Pronto publicaremos nuevas noticias.</p>
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    <div class="mt-8">
        {{ $noticias->links() }}
    </div>
</div>

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endsection