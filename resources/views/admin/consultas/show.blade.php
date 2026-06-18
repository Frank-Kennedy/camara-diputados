@extends('layouts.app')

@section('title', 'Detalle de Consulta')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-parlamento-azul">📬 Detalle de Consulta</h1>
            <a href="{{ route('admin.consultas.index') }}" class="btn-secondary text-sm">
                <i class="fas fa-arrow-left mr-1"></i> Volver
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Información de la consulta -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-wrap justify-between items-start gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <h2 class="text-xl font-bold text-parlamento-azul">{{ $consulta->subject_es }}</h2>
                            <span class="text-xs font-bold px-2 py-1 rounded {{ $consulta->status_color }}">
                                {{ $consulta->status_label }}
                            </span>
                        </div>
                        <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                            <span><i class="fas fa-user mr-1"></i> {{ $consulta->full_name }}</span>
                            <span><i class="fas fa-envelope mr-1"></i> {{ $consulta->email }}</span>
                            @if($consulta->phone)
                                <span><i class="fas fa-phone mr-1"></i> {{ $consulta->phone }}</span>
                            @endif
                            <span><i class="fas fa-tag mr-1"></i> {{ $consulta->type_label }}</span>
                            <span><i class="fas fa-calendar mr-1"></i> {{ $consulta->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('admin.consultas.status', $consulta->id) }}" class="inline">
                            @csrf
                            @method('PUT')
                            <select name="status" onchange="this.form.submit()" 
                                    class="px-3 py-1 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-parlamento-azul">
                                <option value="pendiente" {{ $consulta->status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="en_proceso" {{ $consulta->status == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                <option value="resuelta" {{ $consulta->status == 'resuelta' ? 'selected' : '' }}>Resuelta</option>
                                <option value="archivada" {{ $consulta->status == 'archivada' ? 'selected' : '' }}>Archivada</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mensaje -->
            <div class="p-6 border-b border-gray-200 bg-gray-50">
                <h3 class="font-bold text-parlamento-azul mb-2">📝 Mensaje</h3>
                <div class="bg-white rounded-lg p-4">
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $consulta->message_es }}</p>
                </div>
                @if($consulta->file_attachment)
                    <div class="mt-3">
                        <a href="{{ asset('storage/' . $consulta->file_attachment) }}" target="_blank" 
                           class="text-parlamento-azul hover:underline text-sm">
                            <i class="fas fa-paperclip mr-1"></i> Ver archivo adjunto
                        </a>
                    </div>
                @endif
            </div>

            <!-- Responder -->
            <div class="p-6">
                <h3 class="font-bold text-parlamento-azul mb-4">✉️ Responder</h3>
                <form method="POST" action="{{ route('admin.consultas.respond', $consulta->id) }}">
                    @csrf
                    <textarea name="response_es" rows="4" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul focus:ring-2 focus:ring-parlamento-azul/20 transition"
                              placeholder="Escribe tu respuesta...">{{ old('response_es', $consulta->response_es) }}</textarea>
                    
                    <div class="mt-4 flex gap-3">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-paper-plane mr-2"></i> Enviar Respuesta
                        </button>
                        @if($consulta->response_es)
                            <span class="text-sm text-gray-500 self-center">
                                <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                Respondida el {{ $consulta->response_date ? $consulta->response_date->format('d/m/Y H:i') : '' }}
                            </span>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection