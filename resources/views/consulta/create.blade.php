@extends('layouts.app')

@section('title', 'Atención Ciudadana')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-parlamento-azul">Atención Ciudadana</h1>
                <p class="text-gray-600 mt-2">
                    La Cámara de Diputados escucha tu voz. Envía tus sugerencias, consultas o denuncias.
                </p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('consulta.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Nombre *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Apellido</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Correo Electrónico *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Teléfono</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-medium mb-2">Tipo de Consulta *</label>
                    <select name="type" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                        <option value="">Selecciona un tipo</option>
                        <option value="sugerencia" {{ old('type') == 'sugerencia' ? 'selected' : '' }}>Sugerencia</option>
                        <option value="consulta" {{ old('type') == 'consulta' ? 'selected' : '' }}>Consulta</option>
                        <option value="queja" {{ old('type') == 'queja' ? 'selected' : '' }}>Queja</option>
                        <option value="solicitud" {{ old('type') == 'solicitud' ? 'selected' : '' }}>Solicitud</option>
                        <option value="denuncia" {{ old('type') == 'denuncia' ? 'selected' : '' }}>Denuncia</option>
                    </select>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-medium mb-2">Asunto *</label>
                    <input type="text" name="subject_es" value="{{ old('subject_es') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-medium mb-2">Mensaje *</label>
                    <textarea name="message_es" rows="5" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">{{ old('message_es') }}</textarea>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-medium mb-2">Archivo adjunto (opcional)</label>
                    <input type="file" name="file_attachment"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-parlamento-azul">
                    <p class="text-xs text-gray-500 mt-1">Formatos permitidos: PDF, DOC, DOCX, JPG, PNG. Máx: 5MB</p>
                </div>

                <div class="mt-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_anonymous" value="1" {{ old('is_anonymous') ? 'checked' : '' }}
                            class="mr-2">
                        <span class="text-gray-700">Enviar de forma anónima</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-parlamento-azul text-white py-3 rounded-lg hover:bg-parlamento-azul-claro transition mt-6">
                    Enviar Consulta
                </button>
            </form>
        </div>
    </div>
</div>
@endsection