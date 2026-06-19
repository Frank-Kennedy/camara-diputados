@extends('layouts.app')

@section('title', 'Gestionar Leyes')

@section('content')

<!-- Buscador y Filtros -->
<div class="bg-white rounded-xl shadow-lg p-4 mb-6">
    <form method="GET" action="{{ route('leyes.index') }}" class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="🔍 Buscar por título o código..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
        </div>
        <div>
            <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                <option value="">Todos los tipos</option>
                <option value="ley" {{ request('type') == 'ley' ? 'selected' : '' }}>Ley</option>
                <option value="proyecto" {{ request('type') == 'proyecto' ? 'selected' : '' }}>Proyecto</option>
                <option value="resolucion" {{ request('type') == 'resolucion' ? 'selected' : '' }}>Resolución</option>
                <option value="decreto" {{ request('type') == 'decreto' ? 'selected' : '' }}>Decreto</option>
            </select>
        </div>
        <div>
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                <option value="">Todos los estados</option>
                <option value="propuesta" {{ request('status') == 'propuesta' ? 'selected' : '' }}>Propuesta</option>
                <option value="en_discusion" {{ request('status') == 'en_discusion' ? 'selected' : '' }}>En Discusión</option>
                <option value="aprobada" {{ request('status') == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                <option value="rechazada" {{ request('status') == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                <option value="archivada" {{ request('status') == 'archivada' ? 'selected' : '' }}>Archivada</option>
            </select>
        </div>
        <button type="submit" class="btn-primary">
            <i class="fas fa-search mr-1"></i> Buscar
        </button>
        @if(request('search') || request('type') || request('status'))
            <a href="{{ route('leyes.index') }}" class="btn-secondary">
                <i class="fas fa-times mr-1"></i> Limpiar
            </a>
        @endif
    </form>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="flex flex-wrap justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-parlamento-azul">⚖️ Gestionar Leyes</h1>
            <p class="text-gray-600 mt-1">Administra la legislación y proyectos de ley</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.leyes.create') }}" class="btn-primary">
                <i class="fas fa-plus-circle mr-2"></i> Nueva Ley
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
        <form method="GET" action="{{ route('admin.leyes.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="🔍 Buscar por título o código..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
            </div>
            <div>
                <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    <option value="">Todos los tipos</option>
                    <option value="ley" {{ request('type') == 'ley' ? 'selected' : '' }}>Ley</option>
                    <option value="proyecto" {{ request('type') == 'proyecto' ? 'selected' : '' }}>Proyecto</option>
                    <option value="resolucion" {{ request('type') == 'resolucion' ? 'selected' : '' }}>Resolución</option>
                    <option value="decreto" {{ request('type') == 'decreto' ? 'selected' : '' }}>Decreto</option>
                </select>
            </div>
            <div>
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    <option value="">Todos los estados</option>
                    <option value="propuesta" {{ request('status') == 'propuesta' ? 'selected' : '' }}>Propuesta</option>
                    <option value="en_discusion" {{ request('status') == 'en_discusion' ? 'selected' : '' }}>En Discusión</option>
                    <option value="aprobada" {{ request('status') == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                    <option value="rechazada" {{ request('status') == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                    <option value="archivada" {{ request('status') == 'archivada' ? 'selected' : '' }}>Archivada</option>
                </select>
            </div>
            <button type="submit" class="btn-primary">
                <i class="fas fa-search mr-1"></i> Buscar
            </button>
            @if(request('search') || request('type') || request('status'))
                <a href="{{ route('admin.leyes.index') }}" class="btn-secondary">
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
                        <th class="px-4 py-3 text-left">Código</th>
                        <th class="px-4 py-3 text-left">Título</th>
                        <th class="px-4 py-3 text-left">Tipo</th>
                        <th class="px-4 py-3 text-left">Categoría</th>
                        <th class="px-4 py-3 text-left">Estado</th>
                        <th class="px-4 py-3 text-left">Fecha</th>
                        <th class="px-4 py-3 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leyes as $ley)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $ley->id }}</td>
                            <td class="px-4 py-3 font-mono text-sm">{{ $ley->code }}</td>
                            <td class="px-4 py-3 max-w-[200px] truncate">{{ $ley->title_es }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs font-bold px-2 py-1 rounded bg-gray-100 text-gray-800">
                                    {{ $ley->type_label }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-xs font-bold px-2 py-1 rounded bg-gray-100 text-gray-800">
                                    {{ $ley->category ?? 'Sin categoría' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-xs font-bold px-2 py-1 rounded {{ $ley->status_color }}">
                                    {{ $ley->status_label }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ $ley->presentation_date->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-1 flex-wrap">
                                    <a href="{{ route('leyes.show', $ley->id) }}" target="_blank"
                                       class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition text-xs">
                                        <i class="fas fa-eye"></i> Detalles
                                    </a>
                                    <a href="{{ route('admin.leyes.edit', $ley->id) }}" 
                                       class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 transition text-xs">
                                        <i class="fas fa-edit"></i> Modificar
                                    </a>
                                    @if($ley->file_pdf)
                                        <a href="{{ route('leyes.download', $ley->id) }}" 
                                           class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-red-600 transition text-xs">
                                            <i class="fas fa-file-pdf"></i> Descargar
                                        </a>
                                    @endif
                                    <form method="POST" action="{{ route('admin.leyes.destroy', $ley->id) }}" 
                                          onsubmit="return confirm('¿Eliminar esta ley?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition text-xs">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-gray-500">
                                <i class="fas fa-gavel text-4xl block mb-2 opacity-50"></i>
                                No hay leyes registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200">
            {{ $leyes->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection