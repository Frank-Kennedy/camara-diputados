<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Models\Diputado;
use App\Models\Ley;
use App\Models\Transparencia;
use App\Models\InstitutionalInfo;
use Illuminate\Http\Request;

class InstitutionalController extends Controller
{
    public function home()
    {
        // Últimas noticias (3 destacadas + 6 recientes)
        $noticiasDestacadas = Noticia::where('is_published', true)
            ->where('is_featured', true)
            ->orderBy('published_date', 'desc')
            ->limit(3)
            ->get();

        $noticiasRecientes = Noticia::where('is_published', true)
            ->orderBy('published_date', 'desc')
            ->limit(6)
            ->get();

        // Diputados activos (para mostrar en la página)
        $diputados = Diputado::where('is_active', true)
            ->orderBy('name')
            ->limit(6)
            ->get();

        // Últimas leyes aprobadas
        $leyesRecientes = Ley::where('is_public', true)
            ->where('status', 'aprobada')
            ->orderBy('approval_date', 'desc')
            ->limit(4)
            ->get();

        // Documentos de transparencia recientes
        $transparencia = Transparencia::where('is_public', true)
            ->orderBy('publication_date', 'desc')
            ->limit(4)
            ->get();

        // Información institucional
        $institucion = InstitutionalInfo::where('is_active', true)
            ->orderBy('order')
            ->limit(4)
            ->get();

        // Estadísticas rápidas
        $stats = [
            'diputados' => Diputado::where('is_active', true)->count(),
            'leyes' => Ley::where('is_public', true)->where('status', 'aprobada')->count(),
            'noticias' => Noticia::where('is_published', true)->count(),
            'proyectos' => Ley::where('type', 'proyecto')->where('status', 'en_discusion')->count(),
        ];

        return view('home', compact(
            'noticiasDestacadas',
            'noticiasRecientes',
            'diputados',
            'leyesRecientes',
            'transparencia',
            'institucion',
            'stats'
        ));
    }

    public function index()
    {
        return redirect()->route('home');
    }

    public function show($id)
    {
        return view('institucion.show');
    }
}