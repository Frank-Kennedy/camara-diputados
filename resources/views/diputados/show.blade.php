@extends('layouts.app')

@section('title', $diputado->full_name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-4">
        <a href="{{ route('diputados.index') }}" class="text-parlamento-azul hover:underline">
            ← Volver a Diputados
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="md:flex">
            <!-- Columna izquierda - Foto e info básica -->
            <div class="md:w-1/3 bg-gray-50 p-8 text-center">
                @if($diputado->photo)
                    <img src="{{ asset('storage/' . $diputado->photo) }}" 
                         alt="{{ $diputado->full_name }}" 
                         class="w-48 h-48 rounded-full mx-auto mb-4 object-cover border-4 border-parlamento-oro">
                @else
                    <div class="w-48 h-48 rounded-full mx-auto mb-4 bg-gray-200 flex items-center justify-center text-8xl border-4 border-parlamento-oro">
                        👤
                    </div>
                @endif
                
                <h1 class="text-3xl font-bold text-parlamento-azul">{{ $diputado->full_name }}</h1>
                <p class="text-gray-600 text-lg">{{ $diputado->political_party }}</p>
                <p class="text-gray-500">📍 {{ $diputado->constituency }}</p>
                
                @if($diputado->position)
                    <span class="inline-block bg-parlamento-oro text-white px-4 py-1 rounded-full mt-2">
                        {{ $diputado->position }}
                    </span>
                @endif

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex justify-center gap-4 text-sm">
                        <div>
                            <span class="block text-gray-500">Inicio</span>
                            <span class="font-bold">{{ $diputado->start_date->format('d/m/Y') }}</span>
                        </div>
                        @if($diputado->end_date)
                            <div>
                                <span class="block text-gray-500">Fin</span>
                                <span class="font-bold">{{ $diputado->end_date->format('d/m/Y') }}</span>
                            </div>
                        @endif
                        <div>
                            <span class="block text-gray-500">Estado</span>
                            <span class="inline-block px-2 py-1 rounded text-xs font-bold {{ $diputado->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $diputado->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($diputado->phone || $diputado->email)
                    <div class="mt-4 pt-4 border-t border-gray-200 text-left">
                        @if($diputado->phone)
                            <p class="text-sm"><span class="font-bold">📞 Teléfono:</span> {{ $diputado->phone }}</p>
                        @endif
                        @if($diputado->email)
                            <p class="text-sm"><span class="font-bold">✉️ Email:</span> {{ $diputado->email }}</p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Columna derecha - Biografía y Comisiones -->
            <div class="md:w-2/3 p-8">
                <!-- Biografía -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-parlamento-azul mb-4">Biografía</h2>
                    @if($diputado->biography)
                        <div class="text-gray-700 leading-relaxed">
                            {!! nl2br(e($diputado->biography)) !!}
                        </div>
                    @else
                        <p class="text-gray-500">No hay biografía disponible.</p>
                    @endif
                </div>

                <!-- Comisiones -->
                @if($diputado->comisiones->count() > 0)
                    <div>
                        <h2 class="text-2xl font-bold text-parlamento-azul mb-4">Comisiones</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($diputado->comisiones as $comision)
                                <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-parlamento-oro">
                                    <h4 class="font-bold text-parlamento-azul">{{ $comision->name }}</h4>
                                    @if($comision->pivot->role)
                                        <p class="text-sm text-gray-500">Rol: {{ $comision->pivot->role }}</p>
                                    @endif
                                    <p class="text-sm text-gray-600 mt-1">{{ $comision->description }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Enlaces -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('leyes.index') }}?diputado={{ $diputado->id }}" 
                           class="btn-secondary text-sm">
                            Ver leyes presentadas
                        </a>
                        @auth
                            @if(auth()->user()->isAdmin() || auth()->user()->isEditor())
                                <a href="{{ route('admin.diputados.edit', $diputado->id) }}" 
                                   class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-300 transition">
                                    ✏️ Editar perfil
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection