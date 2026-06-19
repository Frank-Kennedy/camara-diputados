@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-wrap justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-parlamento-azul">📊 Dashboard</h1>
            <p class="text-gray-600 mt-1">Bienvenido, {{ Auth::user()->full_name }}</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="bg-parlamento-azul text-white px-4 py-2 rounded-lg text-sm">
                {{ ucfirst(Auth::user()->role) }}
            </span>
            <a href="{{ route('home') }}" class="btn-secondary text-sm" target="_blank">
                <i class="fas fa-external-link-alt mr-1"></i> Ver portal
            </a>
        </div>
    </div>

    <!-- Tarjetas de estadísticas -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Diputados</p>
                    <p class="text-2xl font-bold text-parlamento-azul">{{ $stats['total_diputados'] }}</p>
                    <p class="text-xs text-green-600">{{ $stats['diputados_activos'] }} activos</p>
                </div>
                <div class="bg-blue-100 text-blue-600 rounded-full w-12 h-12 flex items-center justify-center text-xl">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Leyes</p>
                    <p class="text-2xl font-bold text-parlamento-azul">{{ $stats['total_leyes'] }}</p>
                    <p class="text-xs text-green-600">{{ $stats['leyes_aprobadas'] }} aprobadas</p>
                </div>
                <div class="bg-green-100 text-green-600 rounded-full w-12 h-12 flex items-center justify-center text-xl">
                    <i class="fas fa-gavel"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Noticias</p>
                    <p class="text-2xl font-bold text-parlamento-azul">{{ $stats['total_noticias'] }}</p>
                    <p class="text-xs text-green-600">{{ $stats['noticias_publicadas'] }} publicadas</p>
                </div>
                <div class="bg-purple-100 text-purple-600 rounded-full w-12 h-12 flex items-center justify-center text-xl">
                    <i class="fas fa-newspaper"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Consultas</p>
                    <p class="text-2xl font-bold text-parlamento-azul">{{ $stats['consultas_pendientes'] }}</p>
                    <p class="text-xs text-yellow-600">pendientes</p>
                </div>
                <div class="bg-red-100 text-red-600 rounded-full w-12 h-12 flex items-center justify-center text-xl">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Leyes por estado -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-parlamento-azul mb-4">⚖️ Leyes por Estado</h3>
            <canvas id="chartLeyes" height="250"></canvas>
        </div>

        <!-- Noticias por categoría -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-parlamento-azul mb-4">📰 Noticias por Categoría</h3>
            <canvas id="chartNoticias" height="250"></canvas>
        </div>

        <!-- Consultas por estado -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-parlamento-azul mb-4">📬 Consultas por Estado</h3>
            <canvas id="chartConsultas" height="250"></canvas>
        </div>

        <!-- Actividad mensual -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-parlamento-azul mb-4">📈 Actividad Mensual {{ date('Y') }}</h3>
            <canvas id="chartActividad" height="250"></canvas>
        </div>
    </div>

        <!-- Comisiones -->
    <div class="card hover:-translate-y-1 transition-all duration-300">
        <div class="flex items-center gap-4 mb-4">
            <div class="bg-parlamento-azul/10 p-3 rounded-full text-3xl">🏛️</div>
            <div>
                <h3 class="font-bold text-parlamento-azul">Comisiones</h3>
                <p class="text-sm text-gray-500">Gestionar comisiones</p>
            </div>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.comisiones.index') }}" class="btn-primary text-sm">Listar</a>
            <a href="{{ route('admin.comisiones.create') }}" class="btn-secondary text-sm">Crear</a>
        </div>
    </div>

    <!-- Transparencia -->
    <div class="card hover:-translate-y-1 transition-all duration-300">
        <div class="flex items-center gap-4 mb-4">
            <div class="bg-parlamento-azul/10 p-3 rounded-full text-3xl">📊</div>
            <div>
                <h3 class="font-bold text-parlamento-azul">Transparencia</h3>
                <p class="text-sm text-gray-500">Gestionar documentos</p>
            </div>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.transparencia.index') }}" class="btn-primary text-sm">Listar</a>
            <a href="{{ route('admin.transparencia.create') }}" class="btn-secondary text-sm">Crear</a>
        </div>
    </div>

    <!-- Actividad reciente -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-bold text-parlamento-azul mb-4">📋 Actividad Reciente</h2>
        <div class="space-y-4">
            @foreach($recent_activity['noticias'] as $noticia)
                <div class="flex items-center justify-between border-b pb-3">
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center text-sm">
                            📰
                        </div>
                        <div>
                            <p class="font-semibold text-parlamento-azul text-sm">{{ Str::limit($noticia->title_es, 40) }}</p>
                            <p class="text-xs text-gray-500">{{ $noticia->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <span class="text-xs {{ $noticia->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} px-2 py-1 rounded">
                        {{ $noticia->is_published ? 'Publicada' : 'Borrador' }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico 1: Leyes por estado
    new Chart(document.getElementById('chartLeyes'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($chart_data['leyes_por_estado']['labels']) !!},
            datasets: [{
                data: {!! json_encode($chart_data['leyes_por_estado']['data']) !!},
                backgroundColor: {!! json_encode($chart_data['leyes_por_estado']['colors']) !!}
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Gráfico 2: Noticias por categoría
    new Chart(document.getElementById('chartNoticias'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($chart_data['noticias_por_categoria']['labels']) !!},
            datasets: [{
                label: 'Noticias',
                data: {!! json_encode($chart_data['noticias_por_categoria']['data']) !!},
                backgroundColor: {!! json_encode($chart_data['noticias_por_categoria']['colors']) !!},
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Gráfico 3: Consultas por estado
    new Chart(document.getElementById('chartConsultas'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($chart_data['consultas_por_estado']['labels']) !!},
            datasets: [{
                data: {!! json_encode($chart_data['consultas_por_estado']['data']) !!},
                backgroundColor: {!! json_encode($chart_data['consultas_por_estado']['colors']) !!}
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Gráfico 4: Actividad mensual
    new Chart(document.getElementById('chartActividad'), {
        type: 'line',
        data: {
            labels: {!! json_encode($chart_data['actividad_mensual']['labels']) !!},
            datasets: [
                {
                    label: 'Noticias',
                    data: {!! json_encode($chart_data['actividad_mensual']['noticias']) !!},
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true
                },
                {
                    label: 'Leyes',
                    data: {!! json_encode($chart_data['actividad_mensual']['leyes']) !!},
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush