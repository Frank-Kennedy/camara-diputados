@extends('layouts.app')

@section('title', 'Editar Ley')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-parlamento-azul">✏️ Editar Ley</h1>
            <a href="{{ route('admin.leyes.index') }}" class="btn-secondary text-sm">
                ← Volver
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <form method="POST" action="{{ route('admin.leyes.update', $ley->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Título (Español) *</label>
                    <input type="text" name="title_es" value="{{ old('title_es', $ley->title_es) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Código *</label>
                        <input type="text" name="code" value="{{ old('code', $ley->code) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Tipo *</label>
                        <select name="type" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                            <option value="ley" {{ $ley->type == 'ley' ? 'selected' : '' }}>Ley</option>
                            <option value="proyecto" {{ $ley->type == 'proyecto' ? 'selected' : '' }}>Proyecto de Ley</option>
                            <option value="resolucion" {{ $ley->type == 'resolucion' ? 'selected' : '' }}>Resolución</option>
                            <option value="decreto" {{ $ley->type == 'decreto' ? 'selected' : '' }}>Decreto</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Estado *</label>
                        <select name="status" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                            <option value="propuesta" {{ $ley->status == 'propuesta' ? 'selected' : '' }}>Propuesta</option>
                            <option value="en_discusion" {{ $ley->status == 'en_discusion' ? 'selected' : '' }}>En Discusión</option>
                            <option value="aprobada" {{ $ley->status == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                            <option value="rechazada" {{ $ley->status == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                            <option value="archivada" {{ $ley->status == 'archivada' ? 'selected' : '' }}>Archivada</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Diputado Presentador *</label>
                        <select name="diputado_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                            <option value="">Seleccionar diputado</option>
                            @foreach($diputados as $diputado)
                                <option value="{{ $diputado->id }}" {{ $ley->diputado_id == $diputado->id ? 'selected' : '' }}>
                                    {{ $diputado->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Fecha de Presentación *</label>
                        <input type="date" name="presentation_date" value="{{ old('presentation_date', $ley->presentation_date->format('Y-m-d')) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Fecha de Aprobación</label>
                        <input type="date" name="approval_date" value="{{ old('approval_date', $ley->approval_date ? $ley->approval_date->format('Y-m-d') : '') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-medium mb-2">Comisión</label>
                    <select name="comision_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                        <option value="">Sin comisión asignada</option>
                        @foreach($comisiones as $comision)
                            <option value="{{ $comision->id }}" {{ $ley->comision_id == $comision->id ? 'selected' : '' }}>
                                {{ $comision->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-medium mb-2">Resumen *</label>
                    <textarea name="summary_es" rows="3" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">{{ old('summary_es', $ley->summary_es) }}</textarea>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-medium mb-2">Contenido</label>
                    <textarea name="content_es" rows="8"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">{{ old('content_es', $ley->content_es) }}</textarea>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-medium mb-2">Archivo PDF</label>
                    @if($ley->file_pdf)
                        <div class="mb-2">
                            <span class="text-sm text-gray-600">📄 {{ basename($ley->file_pdf) }}</span>
                            <a href="{{ asset('storage/' . $ley->file_pdf) }}" target="_blank" class="text-blue-600 hover:underline text-sm ml-2">Ver</a>
                        </div>
                    @endif
                    <input type="file" name="file_pdf" accept=".pdf"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener el archivo actual. Máx: 10MB</p>
                </div>

                <div class="mt-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_public" value="1" {{ $ley->is_public ? 'checked' : '' }}
                            class="mr-2">
                        <span class="text-gray-700">Público</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-parlamento-azul text-white py-3 rounded-lg hover:bg-parlamento-azul-claro transition mt-6">
                    Actualizar Ley
                </button>
            </form>
        </div>
    </div>
</div>
@endsection