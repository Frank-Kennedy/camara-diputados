@extends('layouts.app')

@section('title', $documento->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <nav class="text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-parlamento-azul">Inicio</a>
        <span class="mx-2">›</span>
        <a href="{{ route('transparencia.index') }}" class="hover:text-parlamento-azul">Transparencia</a>
        <span class="mx-2">›</span>
        <span class="text-parlamento-azul font-medium">{{ $documento->title }}</span>
    </nav>

    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="p-8">
            <!-- Categoría -->
            <div class="flex flex-wrap items-center gap-2 mb-4">
                <span class="text-xs font-bold px-3 py-1 rounded-full {{ $documento->category_color }}">
                    <i class="fas {{ $documento->category_icon }} mr-1"></i>
                    {{ $documento->category_label }}
                </span>
                <span class="text-sm text-gray-500">{{ $documento->year }}</span>
                <span class="text-sm text-gray-400">{{ $documento->publication_date->format('d/m/Y') }}</span>
            </div>

            <!-- Título -->
            <h1 class="text-3xl font-bold text-parlamento-azul mb-4">
                {{ $documento->title }}
            </h1>

            <!-- Descripción -->
            @if($documento->description)
                <div class="bg-gray-50 rounded-xl p-4 mb-6">
                    <p class="text-gray-700">{{ $documento->description }}</p>
                </div>
            @endif

            <!-- Información -->
            <div class="grid grid-cols-2 gap-4 p-4 bg-gray-50 rounded-xl mb-6">
                <div>
                    <span class="text-sm text-gray-500">Categoría</span>
                    <p class="font-medium">{{ $documento->category_label }}</p>
                </div>
                <div>
                    <span class="text-sm text-gray-500">Año</span>
                    <p class="font-medium">{{ $documento->year }}</p>
                </div>
                <div>
                    <span class="text-sm text-gray-500">Fecha de publicación</span>
                    <p class="font-medium">{{ $documento->publication_date->format('d/m/Y') }}</p>
                </div>
                <div>
                    <span class="text-sm text-gray-500">Descargas</span>
                    <p class="font-medium">{{ $documento->downloads }}</p>
                </div>
            </div>

            <!-- Archivos -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-bold text-parlamento-azul mb-4">📂 Archivos disponibles</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($documento->has_pdf)
                        <a href="{{ route('transparencia.download', $documento->id) }}" 
                           class="flex items-center gap-4 p-4 bg-red-50 border border-red-200 rounded-xl hover:bg-red-100 transition">
                            <div class="text-3xl text-red-500">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div>
                                <p class="font-bold text-red-700">PDF</p>
                                <p class="text-sm text-red-500">Descargar documento</p>
                            </div>
                            <div class="ml-auto text-red-500">
                                <i class="fas fa-download"></i>
                            </div>
                        </a>
                    @endif
                    
                    @if($documento->has_excel)
                        <a href="{{ route('transparencia.download-excel', $documento->id) }}" 
                           class="flex items-center gap-4 p-4 bg-green-50 border border-green-200 rounded-xl hover:bg-green-100 transition">
                            <div class="text-3xl text-green-500">
                                <i class="fas fa-file-excel"></i>
                            </div>
                            <div>
                                <p class="font-bold text-green-700">Excel</p>
                                <p class="text-sm text-green-500">Descargar archivo</p>
                            </div>
                            <div class="ml-auto text-green-500">
                                <i class="fas fa-download"></i>
                            </div>
                        </a>
                    @endif
                    
                    @if(!$documento->has_pdf && !$documento->has_excel)
                        <p class="text-gray-500 col-span-2 text-center py-8">
                            No hay archivos disponibles para este documento.
                        </p>
                    @endif
                </div>
            </div>

            <!-- Botones -->
            <div class="mt-6 pt-6 border-t border-gray-200 flex flex-wrap gap-3">
                <a href="{{ route('transparencia.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Volver a Transparencia
                </a>
                
                @auth
                    @if(auth()->user()->isAdmin() || auth()->user()->isEditor())
                        <a href="{{ route('admin.transparencia.edit', $documento->id) }}" 
                           class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                            <i class="fas fa-edit mr-2"></i> Editar
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection