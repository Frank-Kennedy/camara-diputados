@extends('layouts.app')

@section('title', 'Inicio - Cámara de Diputados')

@section('content')
<!-- ============================================ -->
<!-- HERO / BANNER PRINCIPAL -->
<!-- ============================================ -->
<section class="relative bg-gradient-to-r from-parlamento-azul to-parlamento-azul-claro bg-parlamento-azul-claro" style="background-image: url('{{ asset('images/parlamento-bg1.jpeg') }}');background-size: cover; background-position: center; background-attachment: fixed;">
    <<div class="absolute inset-0 bg-parlamento-azul opacity-70"></div>
    <div class="container mx-auto px-4 py-20 md:py-28 relative z-10">
        <div class="max-w-3xl">
            <div class="inline-block bg-parlamento-oro text-parlamento-azul px-4 py-1 rounded-full text-sm font-bold mb-4">
                {{ date('Y') }} - Legislatura
            </div>
            <h1 class="text-4xl md:text-6xl font-bold mb-4 text-white">
                Cámara de Diputados
            </h1>
            <p class="text-xl md:text-2xl  mb-6 text-white">
                República de Guinea Ecuatorial
            </p>
            <p class="text-lg mb-8 max-w-2xl text-white">
                Trabajando por la transparencia, la participación ciudadana y el desarrollo de nuestra nación.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('noticias.index') }}" class="btn-primary bg-white text-parlamento-azul hover:bg-gray-100">
                    Últimas Noticias
                </a>
                <a href="{{ route('transparencia.index') }}" class="btn-secondary bg-parlamento-oro hover:bg-parlamento-oro-claro">
                    Transparencia
                </a>
                @guest
                    <a href="{{ route('register') }}" class="border-2 border-white px-6 py-3 rounded-lg hover:bg-white hover:text-parlamento-azul transition">
                        Participa
                    </a>
                @endguest
            </div>
        </div>
    </div>
</section>

<!-- ============================================ -->
<!-- ESTADÍSTICAS RÁPIDAS -->
<!-- ============================================ -->
<section class="bg-white py-12 border-b border-gray-200">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="text-4xl font-bold text-parlamento-azul">{{ $stats['diputados'] }}</div>
                <p class="text-gray-600">Diputados Activos</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-parlamento-azul">{{ $stats['leyes'] }}</div>
                <p class="text-gray-600">Leyes Aprobadas</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-parlamento-azul">{{ $stats['noticias'] }}</div>
                <p class="text-gray-600">Publicaciones</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-parlamento-azul">{{ $stats['proyectos'] }}</div>
                <p class="text-gray-600">Proyectos en Discusión</p>
            </div>
        </div>
    </div>
</section>

<!-- ============================================ -->
<!-- NOTICIAS DESTACADAS -->
<!-- ============================================ -->
<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-parlamento-azul">
                📰 Noticias Destacadas
            </h2>
            <a href="{{ route('noticias.index') }}" class="text-parlamento-azul hover:underline">
                Ver todas →
            </a>
        </div>

        @if($noticiasDestacadas->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($noticiasDestacadas as $noticia)
                    <div class="card group hover:-translate-y-1 transition-all duration-300">
                        @if($noticia->featured_image)
                            <img src="{{ asset('storage/' . $noticia->featured_image) }}" 
                                 alt="{{ $noticia->title }}" 
                                 class="w-full h-48 object-cover rounded-t-xl">
                        @else
                            <div class="w-full h-48 bg-gradient-to-r from-parlamento-azul to-parlamento-azul-claro rounded-t-xl flex items-center justify-center text-6xl">
                                📰
                            </div>
                        @endif
                        <div class="p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs font-bold text-white bg-parlamento-azul px-2 py-1 rounded">
                                    {{ $noticia->category_label }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    {{ $noticia->published_date->format('d/m/Y') }}
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-parlamento-azul mb-2 line-clamp-2">
                                {{ $noticia->title }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ $noticia->summary }}
                            </p>
                            <a href="{{ route('noticias.show', $noticia->slug) }}" 
                               class="btn-primary text-sm inline-block">
                                Leer más
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-xl shadow">
                <p class="text-gray-500">No hay noticias destacadas disponibles</p>
            </div>
        @endif
    </div>
</section>

<!-- ============================================ -->
<!-- DIPUTADOS DESTACADOS -->
<!-- ============================================ -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-parlamento-azul">
                👤 Diputados
            </h2>
            <a href="{{ route('diputados.index') }}" class="text-parlamento-azul hover:underline">
                Ver todos →
            </a>
        </div>

        @if($diputados->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($diputados as $diputado)
                    <div class="text-center card hover:-translate-y-1 transition-all duration-300">
                        @if($diputado->photo)
                            <img src="{{ asset('storage/' . $diputado->photo) }}" 
                                 alt="{{ $diputado->full_name }}" 
                                 class="w-24 h-24 rounded-full mx-auto mb-3 object-cover border-4 border-parlamento-oro">
                        @else
                            <div class="w-24 h-24 rounded-full mx-auto mb-3 bg-gray-200 flex items-center justify-center text-3xl border-4 border-parlamento-oro">
                                👤
                            </div>
                        @endif
                        <h4 class="font-bold text-parlamento-azul text-sm">{{ $diputado->full_name }}</h4>
                        <p class="text-xs text-gray-500">{{ $diputado->political_party }}</p>
                        <p class="text-xs text-gray-400">{{ $diputado->constituency }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-gray-50 rounded-xl">
                <p class="text-gray-500">No hay diputados registrados</p>
            </div>
        @endif
    </div>
</section>

<!-- ============================================ -->
<!-- ÚLTIMAS LEYES -->
<!-- ============================================ -->
<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-parlamento-azul">
                ⚖️ Últimas Leyes Aprobadas
            </h2>
            <a href="{{ route('leyes.index') }}" class="text-parlamento-azul hover:underline">
                Ver todas →
            </a>
        </div>

        @if($leyesRecientes->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($leyesRecientes as $ley)
                    <div class="card flex items-start gap-4 hover:-translate-y-1 transition-all duration-300">
                        <div class="bg-parlamento-azul text-white p-3 rounded-lg text-2xl min-w-[50px] text-center">
                            📄
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-bold bg-green-100 text-green-800 px-2 py-1 rounded">
                                    {{ $ley->type_label }}
                                </span>
                                <span class="text-xs text-gray-500">{{ $ley->code }}</span>
                            </div>
                            <h3 class="font-bold text-parlamento-azul">{{ $ley->title }}</h3>
                            <p class="text-sm text-gray-600 line-clamp-2">{{ $ley->summary }}</p>
                            <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                <span>📅 {{ $ley->approval_date ? $ley->approval_date->format('d/m/Y') : $ley->presentation_date->format('d/m/Y') }}</span>
                                @if($ley->file_pdf)
                                    <a href="{{ $ley->pdf_url }}" target="_blank" class="text-parlamento-azul hover:underline">
                                        📥 Descargar PDF
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-xl shadow">
                <p class="text-gray-500">No hay leyes aprobadas recientemente</p>
            </div>
        @endif
    </div>
</section>

<!-- ============================================ -->
<!-- TRANSPARENCIA -->
<!-- ============================================ -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-parlamento-azul">
                📊 Transparencia
            </h2>
            <a href="{{ route('transparencia.index') }}" class="text-parlamento-azul hover:underline">
                Ver más →
            </a>
        </div>

        @if($transparencia->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @foreach($transparencia as $item)
                    <div class="card hover:-translate-y-1 transition-all duration-300 text-center">
                        <div class="text-4xl mb-3"><i calss="{{ $item->category_icon }}"></i></div>
                        <h4 class="font-bold text-parlamento-azul text-sm">{{ $item->title }}</h4>
                        <p class="text-xs text-gray-500">{{ $item->year }}</p>
                        @if($item->file_pdf)
                            <a href="{{ $item->pdf_url }}" target="_blank" class="btn-primary text-xs inline-block mt-3">
                                📥 Descargar
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-gray-50 rounded-xl">
                <p class="text-gray-500">No hay documentos de transparencia disponibles</p>
            </div>
        @endif
    </div>
</section>

<!-- ============================================ -->
<!-- INSTITUCIÓN -->
<!-- ============================================ -->
<section class="py-16 bg-parlamento-azul text-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold mb-6">
                    Sobre la Cámara de Diputados
                </h2>
                <p class="text-gray-300 mb-4">
                    La Cámara de Diputados es el órgano legislativo de la República de Guinea Ecuatorial, 
                    encargado de representar al pueblo, elaborar leyes y controlar la acción del Gobierno.
                </p>
                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div class="bg-white/10 p-4 rounded-lg">
                        <div class="text-2xl mb-1">🏛️</div>
                        <p class="text-sm font-bold">Transparencia</p>
                    </div>
                    <div class="bg-white/10 p-4 rounded-lg">
                        <div class="text-2xl mb-1">🤝</div>
                        <p class="text-sm font-bold">Participación</p>
                    </div>
                    <div class="bg-white/10 p-4 rounded-lg">
                        <div class="text-2xl mb-1">⚖️</div>
                        <p class="text-sm font-bold">Justicia</p>
                    </div>
                    <div class="bg-white/10 p-4 rounded-lg">
                        <div class="text-2xl mb-1">🌍</div>
                        <p class="text-sm font-bold">Desarrollo</p>
                    </div>
                </div>
            </div>
            <div class="bg-white/10 p-8 rounded-2xl">
                <h3 class="text-xl font-bold mb-4">Información de Contacto</h3>
                <div class="space-y-3 text-gray-300">
                    <p>📍 Malabo, Guinea Ecuatorial</p>
                    <p>📞 +240 222 575 742</p>
                    <p>✉️ info@parlamentoge.qq</p>
                    <div class="flex gap-4 mt-4 text-2xl">
                        <a href="#" class="hover:text-parlamento-oro transition">📘</a>
                        <a href="#" class="hover:text-parlamento-oro transition">🐦</a>
                        <a href="#" class="hover:text-parlamento-oro transition">📺</a>
                        <a href="#" class="hover:text-parlamento-oro transition">📷</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================ -->
<!-- ÚLTIMAS NOTICIAS (SECCIÓN SECUNDARIA) -->
<!-- ============================================ -->
<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-parlamento-azul">
                📝 Últimas Noticias
            </h2>
            <a href="{{ route('noticias.index') }}" class="text-parlamento-azul hover:underline">
                Ver todas →
            </a>
        </div>

        @if($noticiasRecientes->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($noticiasRecientes as $noticia)
                    <div class="card hover:-translate-y-1 transition-all duration-300">
                        @if($noticia->featured_image)
                            <img src="{{ asset('storage/' . $noticia->featured_image) }}" 
                                 alt="{{ $noticia->title }}" 
                                 class="w-full h-40 object-cover rounded-t-xl">
                        @else
                            <div class="w-full h-40 bg-gradient-to-r from-gray-300 to-gray-400 rounded-t-xl flex items-center justify-center text-4xl">
                                📰
                            </div>
                        @endif
                        <div class="p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs font-bold text-white bg-parlamento-azul px-2 py-1 rounded">
                                    {{ $noticia->category_label }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    {{ $noticia->published_date->format('d/m/Y') }}
                                </span>
                            </div>
                            <h3 class="font-bold text-parlamento-azul mb-2 line-clamp-2">
                                {{ $noticia->title }}
                            </h3>
                            <p class="text-gray-600 text-sm line-clamp-2">
                                {{ $noticia->summary }}
                            </p>
                            <a href="{{ route('noticias.show', $noticia->slug) }}" 
                               class="text-parlamento-azul text-sm font-bold hover:underline inline-block mt-3">
                                Leer más →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-xl shadow">
                <p class="text-gray-500">No hay noticias disponibles</p>
            </div>
        @endif
    </div>
</section>

<!-- ============================================ -->
<!-- LLAMADA A LA ACCIÓN -->
<!-- ============================================ -->
<section class="py-16 bg-gradient-to-r from-parlamento-oro to-parlamento-oro-claro text-white bg-parlamento-oro">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">
            ¿Quieres participar?
        </h2>
        <p class="text-lg mb-8 max-w-2xl mx-auto">
            La participación ciudadana es fundamental para nuestra democracia. 
            Conoce cómo puedes involucrarte y hacer tu voz escuchar.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('register') }}" class="bg-parlamento-azul text-white px-8 py-3 rounded-lg hover:bg-parlamento-azul-claro transition font-bold">
                Registrarse
            </a>
            <a href="{{ route('consulta.create') }}" class="bg-white text-parlamento-azul px-8 py-3 rounded-lg hover:bg-gray-100 transition font-bold">
                Enviar Consulta
            </a>
        </div>
    </div>
</section>
@endsection