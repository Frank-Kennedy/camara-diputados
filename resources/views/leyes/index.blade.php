@extends('layouts.app')

@section('title', 'Leyes y Legislación')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Encabezado -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-parlamento-azul">⚖️ Leyes y Legislación</h1>
            <p class="text-gray-600 mt-1">Conoce las leyes, proyectos y resoluciones de la Cámara de Diputados</p>
        </div>
        <div>
            @auth
                @if(auth()->user()->isAdmin() || auth()->user()->isEditor())
                    <a href="{{ route('admin.leyes.index') }}" class="btn-secondary">
                        + Gestionar leyes
                    </a>
                @endif
            @endauth
            <span class="bg-parlamento-azul text-white px-4 py-2 rounded-lg text-sm">
                Total: {{ $stats['total'] }} documentos
            </span>
        </div>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-4 text-center">
            <div class="text-2xl font-bold text-parlamento-azul">{{ $stats['total'] }}</div>
            <p class="text-sm text-gray-500">Total</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-4 text-center">
            <div class="text-2xl font-bold text-green-600">{{ $stats['aprobadas'] }}</div>
            <p class="text-sm text-gray-500">Aprobadas</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-4 text-center">
            <div class="text-2xl font-bold text-yellow-600">{{ $stats['proyectos'] }}</div>
            <p class="text-sm text-gray-500">Proyectos</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-4 text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $stats['en_discusion'] }}</div>
            <p class="text-sm text-gray-500">En Discusión</p>
        </div>
    </div>

    <!-- Lista de leyes -->
    @if($leyes->count() > 0)
        <div class="space-y-4">
            @foreach($leyes as $ley)
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition hover:-translate-y-1">
                    <div class="flex flex-wrap justify-between items-start gap-4">
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span class="text-xs font-bold text-white bg-parlamento-azul px-2 py-1 rounded">
                                    {{ $ley->type_label }}
                                </span>
                                <span class="text-xs font-bold px-2 py-1 rounded {{ $ley->status_color }}">
                                    {{ $ley->status_label }}
                                </span>
                                <span class="text-xs text-gray-500">{{ $ley->code }}</span>
                                @if($ley->is_featured)
                                    <span class="text-xs">⭐</span>
                                @endif
                            </div>
                            
                            <h3 class="text-xl font-bold text-parlamento-azul hover:text-parlamento-azul-claro">
                                <a href="{{ route('leyes.show', $ley->id) }}">
                                    {{ $ley->title }}
                                </a>
                            </h3>
                            
                            <p class="text-gray-600 text-sm mt-2 line-clamp-2">
                                {{ $ley->summary }}
                            </p>
                            
                            <div class="flex flex-wrap items-center gap-4 mt-3 text-sm text-gray-500">
                                <span>📅 {{ $ley->presentation_date->format('d/m/Y') }}</span>
                                @if($ley->approval_date)
                                    <span>✅ Aprobada: {{ $ley->approval_date->format('d/m/Y') }}</span>
                                @endif
                                <span>👤 {{ $ley->diputado->full_name ?? 'N/A' }}</span>
                                @if($ley->comision)
                                    <span>🏛️ {{ $ley->comision->name }}</span>
                                @endif
                                <span>👁️ {{ $ley->views }} vistas</span>
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-end gap-2">
                            @if($ley->file_pdf)
                                <a href="{{ route('leyes.download', $ley->id) }}" 
                                   class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition text-sm inline-flex items-center">
                                    📥 PDF
                                </a>
                            @endif
                            <a href="{{ route('leyes.show', $ley->id) }}" 
                               class="btn-primary text-sm inline-block">
                                Ver detalles →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Paginación -->
        <div class="mt-8">
            {{ $leyes->links() }}
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-xl shadow-lg">
            <div class="text-6xl mb-4">⚖️</div>
            <h3 class="text-2xl font-bold text-parlamento-azul mb-2">No hay leyes registradas</h3>
            <p class="text-gray-500">Pronto se publicarán las leyes y proyectos legislativos.</p>
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