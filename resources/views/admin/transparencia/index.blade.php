@extends('layouts.app')

@section('title', 'Gestionar Transparencia')

@section('content')
<!-- Buscador y Filtros -->
<div class="bg-white rounded-xl shadow-lg p-4 mb-6">
    <form method="GET" action="{{ route('transparencia.index') }}" class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="🔍 Buscar documentos..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
        </div>
        <div>
            <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                <option value="">Todas las categorías</option>
                <option value="presupuesto" {{ request('category') == 'presupuesto' ? 'selected' : '' }}>Presupuesto</option>
                <option value="informe_gestion" {{ request('category') == 'informe_gestion' ? 'selected' : '' }}>Informe de Gestión</option>
                <option value="rendicion_cuentas" {{ request('category') == 'rendicion_cuentas' ? 'selected' : '' }}>Rendición de Cuentas</option>
                <option value="contrataciones" {{ request('category') == 'contrataciones' ? 'selected' : '' }}>Contrataciones</option>
                <option value="planificacion" {{ request('category') == 'planificacion' ? 'selected' : '' }}>Planificación</option>
            </select>
        </div>
        <div>
            <select name="year" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                <option value="">Todos los años</option>
                @for($y = date('Y'); $y >= 2020; $y--)
                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="btn-primary">
            <i class="fas fa-search mr-1"></i> Buscar
        </button>
        @if(request('search') || request('category') || request('year'))
            <a href="{{ route('transparencia.index') }}" class="btn-secondary">
                <i class="fas fa-times mr-1"></i> Limpiar
            </a>
        @endif
    </form>
</div>
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-wrap justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-parlamento-azul">📊 Gestionar Transparencia</h1>
            <p class="text-gray-600 mt-1">Administra los documentos de transparencia</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.transparencia.create') }}" class="btn-primary">
                <i class="fas fa-plus-circle mr-2"></i> Nuevo Documento
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

    <!-- Buscador -->
    <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
        <form method="GET" action="{{ route('admin.transparencia.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="🔍 Buscar documentos..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
            </div>
            <div>
                <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    <option value="">Todas las categorías</option>
                    <option value="presupuesto" {{ request('category') == 'presupuesto' ? 'selected' : '' }}>💰 Presupuesto</option>
                    <option value="informe_gestion" {{ request('category') == 'informe_gestion' ? 'selected' : '' }}>📊 Informe de Gestión</option>
                    <option value="rendicion_cuentas" {{ request('category') == 'rendicion_cuentas' ? 'selected' : '' }}>⚖️ Rendición de Cuentas</option>
                    <option value="contrataciones" {{ request('category') == 'contrataciones' ? 'selected' : '' }}>📄 Contrataciones</option>
                    <option value="planificacion" {{ request('category') == 'planificacion' ? 'selected' : '' }}>📅 Planificación</option>
                </select>
            </div>
            <div>
                <select name="year" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    <option value="">Todos los años</option>
                    @for($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="btn-primary">
                <i class="fas fa-search mr-1"></i> Filtrar
            </button>
            @if(request('search') || request('category') || request('year'))
                <a href="{{ route('admin.transparencia.index') }}" class="btn-secondary">
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
                        <th class="px-4 py-3 text-left">Título</th>
                        <th class="px-4 py-3 text-left">Categoría</th>
                        <th class="px-4 py-3 text-left">Año</th>
                        <th class="px-4 py-3 text-left">Archivos</th>
                        <th class="px-4 py-3 text-left">Descargas</th>
                        <th class="px-4 py-3 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documentos as $doc)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $doc->id }}</td>
                            <td class="px-4 py-3 max-w-[200px] truncate font-medium">{{ $doc->title_es }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs font-bold px-2 py-1 rounded {{ $doc->category_color }}">
                                    <i class="fas {{ $doc->category_icon }} mr-1"></i>
                                    {{ $doc->category_label }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ $doc->year }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-1">
                                    @if($doc->has_pdf)
                                        <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded">PDF</span>
                                    @endif
                                    @if($doc->has_excel)
                                        <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded">Excel</span>
                                    @endif
                                    @if(!$doc->has_pdf && !$doc->has_excel)
                                        <span class="text-xs text-gray-400">Sin archivos</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3">{{ $doc->downloads }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-1 flex-wrap">
                                    @if($doc->has_pdf)
                                        <a href="{{ route('transparencia.download', $doc->id) }}" 
                                           class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition text-xs">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    @endif
                                    @if($doc->has_excel)
                                        <a href="{{ route('transparencia.download-excel', $doc->id) }}" 
                                           class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 transition text-xs">
                                            <i class="fas fa-file-excel"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.transparencia.edit', $doc->id) }}" 
                                       class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 transition text-xs">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.transparencia.destroy', $doc->id) }}" 
                                          onsubmit="return confirm('¿Eliminar este documento?')" class="inline">
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
                                <i class="fas fa-file-alt text-4xl block mb-2 opacity-50"></i>
                                No hay documentos registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200">
            {{ $documentos->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection