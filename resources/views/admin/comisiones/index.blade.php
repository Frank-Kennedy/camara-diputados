@extends('layouts.app')

@section('title', 'Gestionar Comisiones')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-wrap justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-parlamento-azul">🏛️ Gestionar Comisiones</h1>
            <p class="text-gray-600 mt-1">Administra las comisiones parlamentarias</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.comisiones.create') }}" class="btn-primary">
                <i class="fas fa-plus-circle mr-2"></i> Nueva Comisión
            </a>
            <a href="{{ route('dashboard') }}" class="btn-secondary text-sm">
                <i class="fas fa-arrow-left mr-1"></i> Volver
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-4 flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-700">&times;</button>
        </div>
    @endif

    <!-- Buscador y filtros -->
    <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
        <form method="GET" action="{{ route('admin.comisiones.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="🔍 Buscar comisiones..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
            </div>
            <div>
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    <option value="">Todos los estados</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Activas</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactivas</option>
                </select>
            </div>
            <button type="submit" class="btn-primary">
                <i class="fas fa-search mr-1"></i> Buscar
            </button>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.comisiones.index') }}" class="btn-secondary">
                    <i class="fas fa-times mr-1"></i> Limpiar
                </a>
            @endif
        </form>
    </div>

    <!-- Tabla -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-parlamento-azul text-white">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Imagen</th>
                        <th class="px-4 py-3 text-left">Nombre</th>
                        <th class="px-4 py-3 text-left">Descripción</th>
                        <th class="px-4 py-3 text-left">Diputados</th>
                        <th class="px-4 py-3 text-left">Estado</th>
                        <th class="px-4 py-3 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comisiones as $comision)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $comision->id }}</td>
                            <td class="px-4 py-3">
                                @if($comision->image)
                                    <img src="{{ asset('storage/' . $comision->image) }}" 
                                         alt="{{ $comision->name }}" 
                                         class="w-12 h-12 object-cover rounded-lg">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center text-2xl">
                                        🏛️
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-medium">{{ $comision->name_es }}</td>
                            <td class="px-4 py-3 max-w-[200px] truncate">{{ $comision->description_es }}</td>
                            <td class="px-4 py-3 text-center">{{ $comision->diputados_count }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs font-bold px-2 py-1 rounded 
                                    {{ $comision->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $comision->is_active ? '✅ Activa' : '❌ Inactiva' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-1 flex-wrap">
                                    <a href="{{ route('comisiones.show', $comision->id) }}" target="_blank"
                                       class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition text-xs">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.comisiones.edit', $comision->id) }}" 
                                       class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 transition text-xs">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.comisiones.toggle', $comision->id) }}" 
                                       class="bg-{{ $comision->is_active ? 'orange' : 'green' }}-500 text-white px-2 py-1 rounded hover:bg-{{ $comision->is_active ? 'orange' : 'green' }}-600 transition text-xs">
                                        <i class="fas fa-{{ $comision->is_active ? 'pause' : 'play' }}"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.comisiones.destroy', $comision->id) }}" 
                                          onsubmit="return confirm('¿Eliminar esta comisión?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition text-xs">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-gray-500">
                                <i class="fas fa-building text-4xl block mb-2 opacity-50"></i>
                                No hay comisiones registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200">
            {{ $comisiones->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection