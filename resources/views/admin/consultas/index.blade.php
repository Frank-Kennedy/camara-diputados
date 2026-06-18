@extends('layouts.app')

@section('title', 'Gestionar Consultas')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-wrap justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-parlamento-azul">📬 Gestionar Consultas</h1>
            <p class="text-gray-600 mt-1">Atención y seguimiento de consultas ciudadanas</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn-secondary text-sm">
            <i class="fas fa-arrow-left mr-1"></i> Volver
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-4 flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-700">&times;</button>
        </div>
    @endif

    <!-- Filtros rápidos -->
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('admin.consultas.index') }}" 
           class="px-4 py-2 rounded-lg {{ !request('status') ? 'bg-parlamento-azul text-white' : 'bg-gray-200 text-gray-700' }}">
            <i class="fas fa-list mr-1"></i> Todas ({{ \App\Models\ConsultaCiudadana::count() }})
        </a>
        <a href="{{ route('admin.consultas.index', ['status' => 'pendiente']) }}" 
           class="px-4 py-2 rounded-lg {{ request('status') == 'pendiente' ? 'bg-yellow-500 text-white' : 'bg-yellow-100 text-yellow-800' }}">
            <i class="fas fa-clock mr-1"></i> Pendientes ({{ \App\Models\ConsultaCiudadana::where('status', 'pendiente')->count() }})
        </a>
        <a href="{{ route('admin.consultas.index', ['status' => 'en_proceso']) }}" 
           class="px-4 py-2 rounded-lg {{ request('status') == 'en_proceso' ? 'bg-blue-500 text-white' : 'bg-blue-100 text-blue-800' }}">
            <i class="fas fa-spinner mr-1"></i> En Proceso ({{ \App\Models\ConsultaCiudadana::where('status', 'en_proceso')->count() }})
        </a>
        <a href="{{ route('admin.consultas.index', ['status' => 'resuelta']) }}" 
           class="px-4 py-2 rounded-lg {{ request('status') == 'resuelta' ? 'bg-green-500 text-white' : 'bg-green-100 text-green-800' }}">
            <i class="fas fa-check mr-1"></i> Resueltas ({{ \App\Models\ConsultaCiudadana::where('status', 'resuelta')->count() }})
        </a>
        <a href="{{ route('admin.consultas.index', ['status' => 'archivada']) }}" 
           class="px-4 py-2 rounded-lg {{ request('status') == 'archivada' ? 'bg-gray-500 text-white' : 'bg-gray-200 text-gray-700' }}">
            <i class="fas fa-archive mr-1"></i> Archivadas ({{ \App\Models\ConsultaCiudadana::where('status', 'archivada')->count() }})
        </a>
    </div>

    <!-- Tabla -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-parlamento-azul text-white">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Nombre</th>
                        <th class="px-4 py-3 text-left">Asunto</th>
                        <th class="px-4 py-3 text-left">Tipo</th>
                        <th class="px-4 py-3 text-left">Estado</th>
                        <th class="px-4 py-3 text-left">Fecha</th>
                        <th class="px-4 py-3 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($consultas as $consulta)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $consulta->id }}</td>
                            <td class="px-4 py-3">
                                <div>
                                    <span class="font-medium">{{ $consulta->name }}</span>
                                    @if($consulta->is_anonymous)
                                        <span class="text-xs text-gray-400 ml-1">(Anónimo)</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 max-w-[150px] truncate">{{ $consulta->subject_es }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs font-bold px-2 py-1 rounded bg-gray-100 text-gray-800">
                                    {{ $consulta->type_label }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-xs font-bold px-2 py-1 rounded {{ $consulta->status_color }}">
                                    <i class="fas {{ $consulta->status == 'pendiente' ? 'fa-clock' : ($consulta->status == 'en_proceso' ? 'fa-spinner' : ($consulta->status == 'resuelta' ? 'fa-check' : 'fa-archive')) }} mr-1"></i>
                                    {{ $consulta->status_label }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ $consulta->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-1 flex-wrap">
                                    <a href="{{ route('admin.consultas.show', $consulta->id) }}" 
                                       class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition text-xs">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($consulta->status != 'resuelta' && $consulta->status != 'archivada')
                                        <form method="POST" action="{{ route('admin.consultas.status', $consulta->id) }}" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="resuelta">
                                            <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 transition text-xs">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.consultas.destroy', $consulta->id) }}" 
                                          onsubmit="return confirm('¿Eliminar esta consulta?')" class="inline">
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
                                <i class="fas fa-envelope text-4xl block mb-2 opacity-50"></i>
                                No hay consultas registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200">
            {{ $consultas->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection