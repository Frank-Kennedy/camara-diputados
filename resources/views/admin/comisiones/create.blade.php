@extends('layouts.app')

@section('title', 'Crear Comisión')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-parlamento-azul">🏛️ Crear Comisión</h1>
            <a href="{{ route('admin.comisiones.index') }}" class="btn-secondary text-sm">
                <i class="fas fa-arrow-left mr-1"></i> Volver
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <form method="POST" action="{{ route('admin.comisiones.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Nombre (Español) *</label>
                        <input type="text" name="name_es" value="{{ old('name_es') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                        @error('name_es') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Nombre (Francés)</label>
                        <input type="text" name="name_fr" value="{{ old('name_fr') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Nombre (Portugués)</label>
                        <input type="text" name="name_pt" value="{{ old('name_pt') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Nombre (Inglés)</label>
                        <input type="text" name="name_en" value="{{ old('name_en') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-medium mb-2">Descripción (Español) *</label>
                    <textarea name="description_es" rows="4" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">{{ old('description_es') }}</textarea>
                    @error('description_es') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Descripción (Francés)</label>
                        <textarea name="description_fr" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">{{ old('description_fr') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Descripción (Portugués)</label>
                        <textarea name="description_pt" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">{{ old('description_pt') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Descripción (Inglés)</label>
                        <textarea name="description_en" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">{{ old('description_en') }}</textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-medium mb-2">Imagen</label>
                    <input type="file" name="image" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, GIF. Máx: 5MB</p>
                    @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mt-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" checked
                            class="mr-2 rounded border-gray-300 text-parlamento-azul focus:ring-parlamento-azul">
                        <span class="text-gray-700">✅ Activa</span>
                    </label>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit"
                        class="flex-1 bg-parlamento-azul text-white py-3 rounded-lg hover:bg-parlamento-azul-claro transition font-medium">
                        <i class="fas fa-save mr-2"></i> Crear Comisión
                    </button>
                    <a href="{{ route('admin.comisiones.index') }}" 
                       class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg hover:bg-gray-400 transition text-center font-medium">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection