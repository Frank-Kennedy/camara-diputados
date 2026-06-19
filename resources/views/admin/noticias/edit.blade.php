@extends('layouts.app')

@section('title', 'Editar Noticia')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-parlamento-azul">✏️ Editar Noticia</h1>
            <a href="{{ route('admin.noticias.index') }}" class="btn-secondary text-sm">
                ← Volver
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <form method="POST" action="{{ route('admin.noticias.update', $noticia->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Título (Español) *</label>
                    <input type="text" name="title_es" value="{{ old('title_es', $noticia->title_es) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Resumen *</label>
                    <textarea name="summary_es" rows="3" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">{{ old('summary_es', $noticia->summary_es) }}</textarea>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-medium mb-2">Contenido *</label>
                    <x-editor name="content_es" :value="old('content_es', $noticia->content_es)" height="500" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Categoría *</label>
                        <select name="category" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                            <option value="institucional" {{ $noticia->category == 'institucional' ? 'selected' : '' }}>Institucional</option>
                            <option value="legislativo" {{ $noticia->category == 'legislativo' ? 'selected' : '' }}>Legislativo</option>
                            <option value="eventos" {{ $noticia->category == 'eventos' ? 'selected' : '' }}>Eventos</option>
                            <option value="comunicados" {{ $noticia->category == 'comunicados' ? 'selected' : '' }}>Comunicados</option>
                            <option value="internacional" {{ $noticia->category == 'internacional' ? 'selected' : '' }}>Internacional</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Fecha de Publicación *</label>
                        <input type="date" name="published_date" value="{{ old('published_date', $noticia->published_date->format('Y-m-d')) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-medium mb-2">Imagen Destacada</label>
                    @if($noticia->featured_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $noticia->featured_image) }}" alt="Imagen actual" class="h-32 w-auto rounded-lg">
                            <p class="text-xs text-gray-500 mt-1">Imagen actual</p>
                        </div>
                    @endif
                    <input type="file" name="featured_image" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener la imagen actual. Formatos: JPG, PNG, GIF. Máx: 5MB</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_published" value="1" {{ $noticia->is_published ? 'checked' : '' }}
                                class="mr-2">
                            <span class="text-gray-700">Publicar</span>
                        </label>
                    </div>
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_featured" value="1" {{ $noticia->is_featured ? 'checked' : '' }}
                                class="mr-2">
                            <span class="text-gray-700">Marcar como destacada ⭐</span>
                        </label>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-parlamento-azul text-white py-3 rounded-lg hover:bg-parlamento-azul-claro transition mt-6">
                    Actualizar Noticia
                </button>
            </form>
        </div>
    </div>
</div>
@endsection