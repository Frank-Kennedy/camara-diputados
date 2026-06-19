@extends('layouts.app')

@section('title', 'Crear Noticia')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-parlamento-azul">📝 Crear Noticia</h1>
            <a href="{{ route('admin.noticias.index') }}" class="btn-secondary text-sm">
                ← Volver
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <form method="POST" action="{{ route('admin.noticias.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Título (Español) *</label>
                    <input type="text" name="title_es" value="{{ old('title_es') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Resumen *</label>
                    <textarea name="summary_es" rows="3" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">{{ old('summary_es') }}</textarea>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-medium mb-2">Contenido *</label>
                    <x-editor name="content_es" :value="old('content_es')" height="500" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Categoría *</label>
                        <select name="category" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                            <option value="">Seleccionar</option>
                            <option value="institucional" {{ old('category') == 'institucional' ? 'selected' : '' }}>Institucional</option>
                            <option value="legislativo" {{ old('category') == 'legislativo' ? 'selected' : '' }}>Legislativo</option>
                            <option value="eventos" {{ old('category') == 'eventos' ? 'selected' : '' }}>Eventos</option>
                            <option value="comunicados" {{ old('category') == 'comunicados' ? 'selected' : '' }}>Comunicados</option>
                            <option value="internacional" {{ old('category') == 'internacional' ? 'selected' : '' }}>Internacional</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Fecha de Publicación *</label>
                        <input type="date" name="published_date" value="{{ old('published_date', date('Y-m-d')) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-medium mb-2">Imagen Destacada</label>
                    <input type="file" name="featured_image" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, GIF. Máx: 5MB</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                                class="mr-2">
                            <span class="text-gray-700">Publicar inmediatamente</span>
                        </label>
                    </div>
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                                class="mr-2">
                            <span class="text-gray-700">Marcar como destacada ⭐</span>
                        </label>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-parlamento-azul text-white py-3 rounded-lg hover:bg-parlamento-azul-claro transition mt-6">
                    Crear Noticia
                </button>
            </form>
        </div>
    </div>
</div>
@endsection