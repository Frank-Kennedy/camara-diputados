@extends('layouts.app')

@section('title', 'Gestionar Noticias')

@section('content')
<!-- Buscador -->
<div class="bg-white rounded-xl shadow-lg p-4 mb-6">
    <form method="GET" action="{{ route('noticias.index') }}" class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="🔍 Buscar noticias..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
        </div>
        <div>
            <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                <option value="">Todas las categorías</option>
                <option value="institucional" {{ request('category') == 'institucional' ? 'selected' : '' }}>Institucional</option>
                <option value="legislativo" {{ request('category') == 'legislativo' ? 'selected' : '' }}>Legislativo</option>
                <option value="eventos" {{ request('category') == 'eventos' ? 'selected' : '' }}>Eventos</option>
                <option value="comunicados" {{ request('category') == 'comunicados' ? 'selected' : '' }}>Comunicados</option>
                <option value="internacional" {{ request('category') == 'internacional' ? 'selected' : '' }}>Internacional</option>
            </select>
        </div>
        <button type="submit" class="btn-primary">
            <i class="fas fa-search mr-1"></i> Buscar
        </button>
        @if(request('search') || request('category'))
            <a href="{{ route('noticias.index') }}" class="btn-secondary">
                <i class="fas fa-times mr-1"></i> Limpiar
            </a>
        @endif
    </form>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="flex flex-wrap justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-parlamento-azul">📰 Gestionar Noticias</h1>
            <p class="text-gray-600 mt-1">Administra las publicaciones del portal</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.noticias.create') }}" class="btn-primary">
                <i class="fas fa-plus-circle mr-2"></i> Nueva Noticia
            </a>
            <a href="{{ route('dashboard') }}" class="btn-secondary text-sm">
                <i class="fas fa-arrow-left mr-1"></i> Volver
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-4 flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-700">&times;</button>
        </div>
    @endif

    <!-- Buscador y filtros -->
    <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
        <form method="GET" action="{{ route('admin.noticias.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="🔍 Buscar noticias..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
            </div>
            <div>
                <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    <option value="">Todas las categorías</option>
                    <option value="institucional" {{ request('category') == 'institucional' ? 'selected' : '' }}>Institucional</option>
                    <option value="legislativo" {{ request('category') == 'legislativo' ? 'selected' : '' }}>Legislativo</option>
                    <option value="eventos" {{ request('category') == 'eventos' ? 'selected' : '' }}>Eventos</option>
                    <option value="comunicados" {{ request('category') == 'comunicados' ? 'selected' : '' }}>Comunicados</option>
                    <option value="internacional" {{ request('category') == 'internacional' ? 'selected' : '' }}>Internacional</option>
                </select>
            </div>
            <div>
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    <option value="">Todos</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Publicadas</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Borradores</option>
                </select>
            </div>
            <button type="submit" class="btn-primary">
                <i class="fas fa-search mr-1"></i> Buscar
            </button>
            @if(request('search') || request('category') || request('status'))
                <a href="{{ route('admin.noticias.index') }}" class="btn-secondary">
                    <i class="fas fa-times mr-1"></i> Limpiar
                </a>
            @endif
        </form>
    </div>

    <!-- Tabla -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-parlamento-azul text-white">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Imagen</th>
                        <th class="px-4 py-3 text-left">Título</th>
                        <th class="px-4 py-3 text-left">Categoría</th>
                        <th class="px-4 py-3 text-left">Estado</th>
                        <th class="px-4 py-3 text-left">Fecha</th>
                        <th class="px-4 py-3 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($noticias as $noticia)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $noticia->id }}</td>
                            <td class="px-4 py-3">
                                @if($noticia->featured_image)
                                    <img src="{{ asset('storage/' . $noticia->featured_image) }}" 
                                         alt="{{ $noticia->title_es }}" 
                                         class="w-12 h-12 object-cover rounded-lg">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center text-2xl">
                                        📰
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 max-w-[200px] truncate font-medium">{{ $noticia->title_es }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs font-bold px-2 py-1 rounded {{ $noticia->category_color }}">
                                    {{ $noticia->category_label }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-xs font-bold px-2 py-1 rounded {{ $noticia->status_color }}">
                                    {{ $noticia->status_label }}
                                </span>
                                @if($noticia->is_featured)
                                    <span class="text-xs text-yellow-500">⭐</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $noticia->published_date->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-1 flex-wrap">
                                    <a href="{{ route('noticias.show', $noticia->slug) }}" target="_blank"
                                       class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition text-xs">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.noticias.edit', $noticia->id) }}" 
                                       class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 transition text-xs">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.noticias.toggle', $noticia->id) }}" 
                                       class="bg-{{ $noticia->is_published ? 'orange' : 'blue' }}-500 text-white px-2 py-1 rounded hover:bg-{{ $noticia->is_published ? 'orange' : 'blue' }}-600 transition text-xs">
                                        <i class="fas fa-{{ $noticia->is_published ? 'pause' : 'play' }}"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.noticias.destroy', $noticia->id) }}" 
                                          onsubmit="return confirm('¿Eliminar esta noticia?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition text-xs">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-gray-500">
                                <i class="fas fa-newspaper text-4xl block mb-2 opacity-50"></i>
                                No hay noticias registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200">
            {{ $noticias->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection