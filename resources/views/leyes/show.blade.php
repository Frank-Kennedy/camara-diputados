@extends('layouts.app')

@section('title', $ley->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Migas de pan -->
    <nav class="text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-parlamento-azul">Inicio</a>
        <span class="mx-2">›</span>
        <a href="{{ route('leyes.index') }}" class="hover:text-parlamento-azul">Leyes</a>
        <span class="mx-2">›</span>
        <span class="text-parlamento-azul font-medium">{{ $ley->title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Contenido principal -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden p-6 md:p-8">
                <!-- Encabezado -->
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="text-xs font-bold text-white bg-parlamento-azul px-3 py-1 rounded-full">
                        {{ $ley->type_label }}
                    </span>
                    <span class="text-xs font-bold px-3 py-1 rounded-full {{ $ley->status_color }}">
                        {{ $ley->status_label }}
                    </span>
                    <span class="text-sm text-gray-500">{{ $ley->code }}</span>
                    @if($ley->is_featured)
                        <span class="text-xs font-bold text-yellow-600 bg-yellow-100 px-3 py-1 rounded-full">⭐</span>
                    @endif
                </div>

                <h1 class="text-3xl md:text-4xl font-bold text-parlamento-azul mb-4">
                    {{ $ley->title }}
                </h1>

                <!-- Información del documento -->
                <div class="flex flex-wrap gap-4 text-sm text-gray-600 border-b border-gray-200 pb-4 mb-4">
                    <span>📅 Presentación: {{ $ley->presentation_date->format('d/m/Y') }}</span>
                    @if($ley->approval_date)
                        <span>✅ Aprobación: {{ $ley->approval_date->format('d/m/Y') }}</span>
                    @endif
                    <span>👁️ {{ $ley->views }} vistas</span>
                    <span>📥 {{ $ley->downloads }} descargas</span>
                </div>

                <!-- Presentado por -->
                <div class="bg-gray-50 rounded-xl p-4 mb-6">
                    <div class="flex flex-wrap items-center gap-6">
                        <div>
                            <span class="text-sm text-gray-500">Presentado por</span>
                            <p class="font-bold text-parlamento-azul">
                                {{ $ley->diputado->full_name ?? 'N/A' }}
                            </p>
                        </div>
                        @if($ley->comision)
                            <div>
                                <span class="text-sm text-gray-500">Comisión</span>
                                <p class="font-bold text-parlamento-azul">
                                    {{ $ley->comision->name }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Resumen -->
                <div class="bg-parlamento-azul/5 rounded-xl p-4 mb-6 border-l-4 border-parlamento-oro">
                    <h3 class="font-bold text-parlamento-azul mb-2">📌 Resumen</h3>
                    <p class="text-gray-700">{{ $ley->summary }}</p>
                </div>

                <!-- Contenido completo -->
                @if($ley->content)
                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                        <h3 class="text-xl font-bold text-parlamento-azul mb-4">📄 Contenido</h3>
                        {!! nl2br(e($ley->content)) !!}
                    </div>
                @endif

                <!-- Botones de acción -->
                <div class="mt-6 pt-6 border-t border-gray-200 flex flex-wrap gap-3">
                    @if($ley->file_pdf)
                        <a href="{{ route('leyes.download', $ley->id) }}" 
                           class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 transition inline-flex items-center">
                            📥 Descargar PDF
                        </a>
                    @endif
                    
                    <a href="{{ route('leyes.index') }}" class="btn-secondary">
                        ← Volver a leyes
                    </a>

                    @auth
                        @if(auth()->user()->isAdmin() || auth()->user()->isEditor())
                            <a href="{{ route('admin.leyes.edit', $ley->id) }}" 
                               class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                                ✏️ Editar
                            </a>
                            <form method="POST" action="{{ route('admin.leyes.destroy', $ley->id) }}" 
                                  onsubmit="return confirm('¿Eliminar esta ley?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Información rápida -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-parlamento-azul mb-4">📋 Información</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-gray-500">Tipo</span>
                        <p class="font-bold">{{ $ley->type_label }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">Estado</span>
                        <p><span class="font-bold px-2 py-1 rounded {{ $ley->status_color }}">{{ $ley->status_label }}</span></p>
                    </div>
                    <div>
                        <span class="text-gray-500">Código</span>
                        <p class="font-bold">{{ $ley->code }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">Presentado</span>
                        <p>{{ $ley->presentation_date->format('d/m/Y') }}</p>
                    </div>
                    @if($ley->approval_date)
                        <div>
                            <span class="text-gray-500">Aprobado</span>
                            <p>{{ $ley->approval_date->format('d/m/Y') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Leyes relacionadas -->
            @if(isset($relacionadas) && $relacionadas->count() > 0)
                <div class="bg-white rounded-xl shadow-lg p-6 mt-6">
                    <h3 class="text-xl font-bold text-parlamento-azul mb-4">📚 Relacionadas</h3>
                    <div class="space-y-3">
                        @foreach($relacionadas as $rel)
                            <a href="{{ route('leyes.show', $rel->id) }}" 
                               class="block hover:bg-gray-50 p-3 rounded-lg transition">
                                <h4 class="font-semibold text-parlamento-azul text-sm">{{ $rel->title }}</h4>
                                <p class="text-xs text-gray-500">{{ $rel->code }} · {{ $rel->status_label }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Compartir -->
            <div class="bg-white rounded-xl shadow-lg p-6 mt-6">
                <h3 class="text-xl font-bold text-parlamento-azul mb-4">🔗 Compartir</h3>
                <div class="flex gap-2">
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($ley->title) }}&url={{ urlencode(request()->fullUrl()) }}" 
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
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .prose {
        font-size: 1rem;
        line-height: 1.8;
    }
    .prose p {
        margin-bottom: 1rem;
    }
    .prose h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a3a5c;
        margin-top: 1.5rem;
        margin-bottom: 0.8rem;
    }
    .prose ul {
        list-style: disc;
        padding-left: 1.5rem;
    }
</style>
@endpush
@endsection