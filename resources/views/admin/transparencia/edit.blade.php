@extends('layouts.app')

@section('title', 'Editar Documento')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-parlamento-azul">✏️ Editar Documento</h1>
            <a href="{{ route('admin.transparencia.index') }}" class="btn-secondary text-sm">
                <i class="fas fa-arrow-left mr-1"></i> Volver
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <form method="POST" action="{{ route('admin.transparencia.update', $documento->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Título (Español) *</label>
                    <input type="text" name="title_es" value="{{ old('title_es', $documento->title_es) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Categoría *</label>
                        <select name="category" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                            <option value="presupuesto" {{ $documento->category == 'presupuesto' ? 'selected' : '' }}>💰 Presupuesto</option>
                            <option value="informe_gestion" {{ $documento->category == 'informe_gestion' ? 'selected' : '' }}>📊 Informe de Gestión</option>
                            <option value="rendicion_cuentas" {{ $documento->category == 'rendicion_cuentas' ? 'selected' : '' }}>⚖️ Rendición de Cuentas</option>
                            <option value="contrataciones" {{ $documento->category == 'contrataciones' ? 'selected' : '' }}>📄 Contrataciones</option>
                            <option value="planificacion" {{ $documento->category == 'planificacion' ? 'selected' : '' }}>📅 Planificación</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Año *</label>
                        <select name="year" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                            @for($y = date('Y') + 1; $y >= 2020; $y--)
                                <option value="{{ $y }}" {{ $documento->year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-medium mb-2">Descripción</label>
                    <textarea name="description_es" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">{{ old('description_es', $documento->description_es) }}</textarea>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-medium mb-2">Fecha de Publicación *</label>
                    <input type="date" name="publication_date" value="{{ old('publication_date', $documento->publication_date->format('Y-m-d')) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-medium mb-2">Archivo PDF</label>
                    @if($documento->has_pdf)
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-sm text-gray-600">📄 {{ basename($documento->file_pdf) }}</span>
                            <a href="{{ asset('storage/' . $documento->file_pdf) }}" target="_blank" 
                               class="text-blue-600 hover:underline text-sm">Ver</a>
                        </div>
                    @endif
                    <input type="file" name="file_pdf" accept=".pdf"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener el archivo actual. Máx: 20MB</p>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-medium mb-2">Archivo Excel</label>
                    @if($documento->has_excel)
                        <div class="mb-2 flex items-center gap-2">
                            <span class="text-sm text-gray-600">📊 {{ basename($documento->file_excel) }}</span>
                            <a href="{{ asset('storage/' . $documento->file_excel) }}" target="_blank" 
                               class="text-blue-600 hover:underline text-sm">Ver</a>
                        </div>
                    @endif
                    <input type="file" name="file_excel" accept=".xls,.xlsx"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener el archivo actual. Máx: 10MB</p>
                </div>

                <div class="mt-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_public" value="1" {{ $documento->is_public ? 'checked' : '' }}
                            class="mr-2 rounded border-gray-300 text-parlamento-azul focus:ring-parlamento-azul">
                        <span class="text-gray-700">✅ Público</span>
                    </label>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit"
                        class="flex-1 bg-parlamento-azul text-white py-3 rounded-lg hover:bg-parlamento-azul-claro transition font-medium">
                        <i class="fas fa-save mr-2"></i> Actualizar
                    </button>
                    <a href="{{ route('admin.transparencia.index') }}" 
                       class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg hover:bg-gray-400 transition text-center font-medium">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection