@extends('layouts.app')

@section('title', $noticia->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Migas de pan -->
    <nav class="text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-parlamento-azul">Inicio</a>
        <span class="mx-2">›</span>
        <a href="{{ route('noticias.index') }}" class="hover:text-parlamento-azul">Noticias</a>
        <span class="mx-2">›</span>
        <span class="text-parlamento-azul font-medium">{{ $noticia->title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Contenido principal -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Imagen destacada -->
                @if($noticia->featured_image)
                    <img src="{{ asset('storage/' . $noticia->featured_image) }}" 
                         alt="{{ $noticia->title }}" 
                         class="w-full h-64 md:h-96 object-cover">
                @else
                    <div class="w-full h-64 md:h-96 bg-gradient-to-r from-parlamento-azul to-parlamento-azul-claro flex items-center justify-center text-6xl text-white">
                        📰
                    </div>
                @endif

                <div class="p-6 md:p-8">
                    <!-- Categoría y fecha -->
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <span class="text-xs font-bold text-white bg-parlamento-azul px-3 py-1 rounded-full">
                            {{ $noticia->category_label }}
                        </span>
                        <span class="text-sm text-gray-500">
                            📅 {{ $noticia->published_date->format('d/m/Y') }}
                        </span>
                        <span class="text-sm text-gray-500">
                            👁️ {{ $noticia->views }} vistas
                        </span>
                        @if($noticia->is_featured)
                            <span class="text-xs font-bold text-yellow-600 bg-yellow-100 px-3 py-1 rounded-full">
                                ⭐ Destacada
                            </span>
                        @endif
                    </div>

                    <!-- Título -->
                    <h1 class="text-3xl md:text-4xl font-bold text-parlamento-azul mb-4">
                        {{ $noticia->title }}
                    </h1>

                    <!-- Resumen -->
                    <div class="text-lg text-gray-700 border-l-4 border-parlamento-oro pl-4 mb-6 italic">
                        {{ $noticia->summary }}
                    </div>

                    <!-- Contenido -->
                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                        {!! $noticia->content !!}
                    </div>

                    <!-- Tags -->
                    @if($noticia->tags)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex flex-wrap gap-2">
                                @foreach($noticia->tags as $tag)
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                        #{{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Botones de administración -->
                    @auth
                        @if(auth()->user()->isAdmin() || auth()->user()->isEditor())
                            <div class="mt-6 pt-6 border-t border-gray-200 flex gap-2">
                                <a href="{{ route('admin.noticias.edit', $noticia->id) }}" 
                                   class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition text-sm">
                                    ✏️ Editar
                                </a>
                                <a href="{{ route('admin.noticias.toggle', $noticia->id) }}" 
                                   class="bg-{{ $noticia->is_published ? 'orange' : 'blue' }}-500 text-white px-4 py-2 rounded-lg hover:bg-{{ $noticia->is_published ? 'orange' : 'blue' }}-600 transition text-sm">
                                    {{ $noticia->is_published ? '📄 Despublicar' : '📄 Publicar' }}
                                </a>
                                <form method="POST" action="{{ route('admin.noticias.destroy', $noticia->id) }}" 
                                      onsubmit="return confirm('¿Eliminar esta noticia?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition text-sm">
                                        🗑️ Eliminar
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Noticias relacionadas -->
            @if($relacionadas->count() > 0)
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-parlamento-azul mb-4">📰 Noticias Relacionadas</h3>
                    <div class="space-y-4">
                        @foreach($relacionadas as $relacionada)
                            <a href="{{ route('noticias.show', $relacionada->slug) }}" 
                               class="block hover:bg-gray-50 p-3 rounded-lg transition">
                                <div class="flex items-start gap-3">
                                    @if($relacionada->featured_image)
                                        <img src="{{ asset('storage/' . $relacionada->featured_image) }}" 
                                             alt="{{ $relacionada->title }}" 
                                             class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center text-2xl flex-shrink-0">
                                            📰
                                        </div>
                                    @endif
                                    <div>
                                        <h4 class="font-semibold text-parlamento-azul text-sm line-clamp-2">
                                            {{ $relacionada->title }}
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $relacionada->published_date->format('d/m/Y') }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Compartir -->
            <div class="bg-white rounded-xl shadow-lg p-6 mt-6">
                <h3 class="text-xl font-bold text-parlamento-azul mb-4">🔗 Compartir</h3>
                <div class="flex gap-2">
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($noticia->title) }}&url={{ urlencode(request()->fullUrl()) }}" 
                       target="_blank" 
                       class="bg-[#1DA1F2] text-white px-4 py-2 rounded-lg hover:bg-[#1a8cd8] transition text-sm flex-1 text-center">
                        🐦 Twitter
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                       target="_blank" 
                       class="bg-[#4267B2] text-white px-4 py-2 rounded-lg hover:bg-[#365899] transition text-sm flex-1 text-center">
                        📘 Facebook
                    </a>
                </div>
                <div class="mt-2">
                    <button onclick="navigator.clipboard.writeText('{{ request()->fullUrl() }}')" 
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition text-sm w-full">
                        📋 Copiar enlace
                    </button>
                </div>
            </div>

            <!-- Volver -->
            <div class="mt-6">
                <a href="{{ route('noticias.index') }}" class="btn-secondary text-sm w-full text-center block">
                    ← Volver a Noticias
                </a>
            </div>
        </div>
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
    .prose {
        font-size: 1.05rem;
        line-height: 1.8;
    }
    .prose p {
        margin-bottom: 1.2rem;
    }
    .prose img {
        max-width: 100%;
        border-radius: 0.5rem;
        margin: 1.5rem 0;
    }
    .prose h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a3a5c;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    .prose h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a3a5c;
        margin-top: 1.5rem;
        margin-bottom: 0.8rem;
    }
    .prose ul {
        list-style: disc;
        padding-left: 1.5rem;
        margin-bottom: 1rem;
    }
    .prose ol {
        list-style: decimal;
        padding-left: 1.5rem;
        margin-bottom: 1rem;
    }
</style>
@endpush
@endsection