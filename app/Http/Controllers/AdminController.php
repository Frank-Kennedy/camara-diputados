<?php

namespace App\Http\Controllers;

use App\Models\Diputado;
use App\Models\Ley;
use App\Models\Noticia;
use App\Models\ConsultaCiudadana;
use App\Models\User;
use App\Models\Transparencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Estadísticas generales
        $stats = [
            'total_diputados' => Diputado::count(),
            'diputados_activos' => Diputado::where('is_active', true)->count(),
            'total_leyes' => Ley::count(),
            'leyes_aprobadas' => Ley::where('status', 'aprobada')->count(),
            'total_noticias' => Noticia::count(),
            'noticias_publicadas' => Noticia::where('is_published', true)->count(),
            'consultas_pendientes' => ConsultaCiudadana::where('status', 'pendiente')->count(),
            'total_usuarios' => User::count(),
            'total_transparencia' => Transparencia::count(),
        ];

        // Datos para gráficos
        $chart_data = [
            'leyes_por_estado' => [
                'labels' => ['Propuesta', 'En Discusión', 'Aprobada', 'Rechazada', 'Archivada'],
                'data' => [
                    Ley::where('status', 'propuesta')->count(),
                    Ley::where('status', 'en_discusion')->count(),
                    Ley::where('status', 'aprobada')->count(),
                    Ley::where('status', 'rechazada')->count(),
                    Ley::where('status', 'archivada')->count(),
                ],
                'colors' => ['#fbbf24', '#60a5fa', '#34d399', '#f87171', '#9ca3af']
            ],
            'noticias_por_categoria' => [
                'labels' => ['Institucional', 'Legislativo', 'Eventos', 'Comunicados', 'Internacional'],
                'data' => [
                    Noticia::where('category', 'institucional')->count(),
                    Noticia::where('category', 'legislativo')->count(),
                    Noticia::where('category', 'eventos')->count(),
                    Noticia::where('category', 'comunicados')->count(),
                    Noticia::where('category', 'internacional')->count(),
                ],
                'colors' => ['#3b82f6', '#8b5cf6', '#10b981', '#f59e0b', '#ef4444']
            ],
            'consultas_por_estado' => [
                'labels' => ['Pendiente', 'En Proceso', 'Resuelta', 'Archivada'],
                'data' => [
                    ConsultaCiudadana::where('status', 'pendiente')->count(),
                    ConsultaCiudadana::where('status', 'en_proceso')->count(),
                    ConsultaCiudadana::where('status', 'resuelta')->count(),
                    ConsultaCiudadana::where('status', 'archivada')->count(),
                ],
                'colors' => ['#f59e0b', '#3b82f6', '#10b981', '#6b7280']
            ],
            'actividad_mensual' => [
                'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                'noticias' => [],
                'leyes' => [],
            ]
        ];

        // Actividad mensual
        for ($i = 1; $i <= 12; $i++) {
            $chart_data['actividad_mensual']['noticias'][] = Noticia::whereMonth('created_at', $i)->whereYear('created_at', date('Y'))->count();
            $chart_data['actividad_mensual']['leyes'][] = Ley::whereMonth('created_at', $i)->whereYear('created_at', date('Y'))->count();
        }

        // Actividad reciente
        $recent_activity = [
            'noticias' => Noticia::orderBy('created_at', 'desc')->limit(5)->get(),
            'consultas' => ConsultaCiudadana::orderBy('created_at', 'desc')->limit(5)->get(),
            'leyes' => Ley::orderBy('created_at', 'desc')->limit(5)->get(),
        ];

        return view('admin.dashboard', compact('stats', 'chart_data', 'recent_activity'));
    }
}