@extends('layouts.app')

@section('title', 'Transparencia')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Encabezado -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-parlamento-azul">📊 Transparencia</h1>
        <p class="text-gray-600 mt-2 max-w-2xl mx-auto">
            La Cámara de Diputados garantiza el acceso a la información pública y promueve la transparencia en la gestión institucional.
        </p>
        <div class="mt-4 inline-block bg-parlamento-azul text-white px-6 py-2 rounded-lg">
            <i class="fas fa-file-alt mr-2"></i> {{ $total }} documentos disponibles
        </div>
    </div>

    <!-- Categorías -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        @foreach($categorias as $key => $count)
            <a href="#{{ $key }}" 
               class="bg-white rounded-xl shadow-lg p-4 text-center hover:shadow-xl transition hover:-translate-y-1">
                <div class="text-3xl mb-2">
                    @php
                        $icons = [
                            'presupuesto' => '💰',
                            'informe_gestion' => '📊',
                            'rendicion_cuentas' => '⚖️',
                            'contrataciones' => '📄',
                            'planificacion' => '📅',
                        ];
                    @endphp
                    {{ $icons[$key] ?? '📁' }}
                </div>
                <p class="text-sm font-bold text-parlamento-azul">
                    {{ ucfirst(str_replace('_', ' ', $key)) }}
                </p>
                <p class="text-xs text-gray-500">{{ $count }} documentos</p>
            </a>
        @endforeach
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl shadow-lg p-4 mb-8">
        <form method="GET" action="{{ route('transparencia.index') }}" class="flex flex-wrap gap-4">
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
                <a href="{{ route('transparencia.index') }}" class="btn-secondary">
                    <i class="fas fa-times mr-1"></i> Limpiar
                </a>
            @endif
        </form>
    </div>

    <!-- Lista de documentos -->
    @if($documentos->count() > 0)
        <div class="space-y-4">
            @foreach($documentos as $doc)
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition hover:-translate-y-1">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span class="text-xs font-bold px-2 py-1 rounded {{ $doc->category_color }}">
                                    <i class="fas {{ $doc->category_icon }} mr-1"></i>
                                    {{ $doc->category_label }}
                                </span>
                                <span class="text-xs text-gray-500">{{ $doc->year }}</span>
                                <span class="text-xs text-gray-400">{{ $doc->publication_date->format('d/m/Y') }}</span>
                            </div>
                            
                            <h3 class="text-xl font-bold text-parlamento-azul">
                                {{ $doc->title }}
                            </h3>
                            
                            @if($doc->description)
                                <p class="text-gray-600 text-sm mt-2 line-clamp-2">
                                    {{ $doc->description }}
                                </p>
                            @endif
                            
                            <div class="flex flex-wrap items-center gap-4 mt-3 text-sm text-gray-500">
                                <span><i class="fas fa-download mr-1"></i> {{ $doc->downloads }} descargas</span>
                                @if($doc->has_pdf)
                                    <span class="text-red-500"><i class="fas fa-file-pdf mr-1"></i> PDF</span>
                                @endif
                                @if($doc->has_excel)
                                    <span class="text-green-500"><i class="fas fa-file-excel mr-1"></i> Excel</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-end gap-2">
                            @if($doc->has_pdf)
                                <a href="{{ route('transparencia.download', $doc->id) }}" 
                                   class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition text-sm inline-flex items-center">
                                    <i class="fas fa-file-pdf mr-2"></i> PDF
                                </a>
                            @endif
                            @if($doc->has_excel)
                                <a href="{{ route('transparencia.download-excel', $doc->id) }}" 
                                   class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition text-sm inline-flex items-center">
                                    <i class="fas fa-file-excel mr-2"></i> Excel
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Paginación -->
        <div class="mt-8">
            {{ $documentos->links() }}
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-xl shadow-lg">
            <div class="text-6xl mb-4">📊</div>
            <h3 class="text-2xl font-bold text-parlamento-azul mb-2">No hay documentos disponibles</h3>
            <p class="text-gray-500">Pronto se publicarán los documentos de transparencia.</p>
        </div>
    @endif
</div>

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endsection