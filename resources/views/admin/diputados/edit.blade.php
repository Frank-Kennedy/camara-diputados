@extends('layouts.app')

@section('title', 'Editar Diputado')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-parlamento-azul">✏️ Editar Diputado</h1>
            <a href="{{ route('admin.diputados.index') }}" class="btn-secondary text-sm">
                <i class="fas fa-arrow-left mr-1"></i> Volver
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <form method="POST" action="{{ route('admin.diputados.update', $diputado->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Nombre *</label>
                        <input type="text" name="name" value="{{ old('name', $diputado->name) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul focus:ring-2 focus:ring-parlamento-azul/20 transition">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Apellido *</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $diputado->last_name) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul focus:ring-2 focus:ring-parlamento-azul/20 transition">
                        @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $diputado->email) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul focus:ring-2 focus:ring-parlamento-azul/20 transition">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Teléfono</label>
                        <input type="text" name="phone" value="{{ old('phone', $diputado->phone) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul focus:ring-2 focus:ring-parlamento-azul/20 transition">
                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Partido Político *</label>
                        <input type="text" name="political_party" value="{{ old('political_party', $diputado->political_party) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul focus:ring-2 focus:ring-parlamento-azul/20 transition">
                        @error('political_party') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Circunscripción *</label>
                        <input type="text" name="constituency" value="{{ old('constituency', $diputado->constituency) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul focus:ring-2 focus:ring-parlamento-azul/20 transition">
                        @error('constituency') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Cargo</label>
                        <input type="text" name="position" value="{{ old('position', $diputado->position) }}"
                            placeholder="Ej: Presidente, Vicepresidente..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul focus:ring-2 focus:ring-parlamento-azul/20 transition">
                        @error('position') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Fecha de Inicio *</label>
                        <input type="date" name="start_date" value="{{ old('start_date', $diputado->start_date->format('Y-m-d')) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul focus:ring-2 focus:ring-parlamento-azul/20 transition">
                        @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-medium mb-2">Fecha de Fin</label>
                    <input type="date" name="end_date" value="{{ old('end_date', $diputado->end_date ? $diputado->end_date->format('Y-m-d') : '') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul focus:ring-2 focus:ring-parlamento-azul/20 transition">
                    @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-medium mb-2">Biografía</label>
                    <textarea name="biography_es" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul focus:ring-2 focus:ring-parlamento-azul/20 transition">{{ old('biography_es', $diputado->biography_es) }}</textarea>
                    @error('biography_es') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-medium mb-2">Foto</label>
                    @if($diputado->photo)
                        <div class="mb-2 flex items-center gap-3">
                            <img src="{{ asset('storage/' . $diputado->photo) }}" 
                                 alt="{{ $diputado->full_name }}" 
                                 class="w-16 h-16 rounded-full object-cover">
                            <span class="text-sm text-gray-500">Foto actual</span>
                        </div>
                    @endif
                    <input type="file" name="photo" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul focus:ring-2 focus:ring-parlamento-azul/20 transition">
                    <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, GIF. Máx: 5MB. Dejar vacío para mantener la foto actual.</p>
                    @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mt-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ $diputado->is_active ? 'checked' : '' }}
                            class="mr-2 rounded border-gray-300 text-parlamento-azul focus:ring-parlamento-azul">
                        <span class="text-gray-700">✅ Activo</span>
                    </label>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit"
                        class="flex-1 bg-parlamento-azul text-white py-3 rounded-lg hover:bg-parlamento-azul-claro transition font-medium">
                        <i class="fas fa-save mr-2"></i> Actualizar Diputado
                    </button>
                    <a href="{{ route('admin.diputados.index') }}" 
                       class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg hover:bg-gray-400 transition text-center font-medium">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection