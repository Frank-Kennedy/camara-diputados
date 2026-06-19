@extends('layouts.app')

@section('title', 'Gestionar Diputados')

@section('content')
<!-- Buscador -->
<div class="bg-white rounded-xl shadow-lg p-4 mb-6">
    <form method="GET" action="{{ route('diputados.index') }}" class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="🔍 Buscar por nombre, partido o circunscripción..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
        </div>
        <button type="submit" class="btn-primary">
            <i class="fas fa-search mr-1"></i> Buscar
        </button>
        @if(request('search'))
            <a href="{{ route('diputados.index') }}" class="btn-secondary">
                <i class="fas fa-times mr-1"></i> Limpiar
            </a>
        @endif
    </form>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="flex flex-wrap justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-parlamento-azul">👤 Gestionar Diputados</h1>
            <p class="text-gray-600 mt-1">Administra los perfiles de los diputados</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.diputados.create') }}" class="btn-primary">
                <i class="fas fa-user-plus mr-2"></i> Nuevo Diputado
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

    <!-- Buscador -->
    <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
        <form method="GET" action="{{ route('admin.diputados.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="🔍 Buscar por nombre, email o partido..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
            </div>
            <div>
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    <option value="">Todos los estados</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Activos</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactivos</option>
                </select>
            </div>
            <button type="submit" class="btn-primary">
                <i class="fas fa-search mr-1"></i> Buscar
            </button>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.diputados.index') }}" class="btn-secondary">
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
                        <th class="px-4 py-3 text-left">Foto</th>
                        <th class="px-4 py-3 text-left">Nombre</th>
                        <th class="px-4 py-3 text-left">Partido</th>
                        <th class="px-4 py-3 text-left">Circunscripción</th>
                        <th class="px-4 py-3 text-left">Estado</th>
                        <th class="px-4 py-3 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($diputados as $diputado)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $diputado->id }}</td>
                            <td class="px-4 py-3">
                                @if($diputado->photo)
                                    <img src="{{ asset('storage/' . $diputado->photo) }}" 
                                         alt="{{ $diputado->full_name }}" 
                                         class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-xl">
                                        👤
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-medium">{{ $diputado->full_name }}</td>
                            <td class="px-4 py-3">{{ $diputado->political_party }}</td>
                            <td class="px-4 py-3">{{ $diputado->constituency }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs font-bold px-2 py-1 rounded 
                                    {{ $diputado->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $diputado->is_active ? '✅ Activo' : '❌ Inactivo' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-1 flex-wrap">
                                    <a href="{{ route('diputados.show', $diputado->id) }}" target="_blank"
                                       class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition text-xs">
                                        <i class="fas fa-eye"></i> Detalles
                                    </a>
                                    <a href="{{ route('admin.diputados.edit', $diputado->id) }}" 
                                       class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 transition text-xs">
                                        <i class="fas fa-edit"></i> Modificar
                                    </a>
                                    <form method="POST" action="{{ route('admin.diputados.destroy', $diputado->id) }}" 
                                          onsubmit="return confirm('¿Eliminar este diputado?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition text-xs">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-gray-500">
                                <i class="fas fa-users text-4xl block mb-2 opacity-50"></i>
                                No hay diputados registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200">
            {{ $diputados->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection