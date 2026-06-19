<?php

namespace App\Http\Controllers;

use App\Models\Ley;
use App\Models\Diputado;
use App\Models\Comision;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LeyController extends Controller
{
    /**
     * Página pública - Lista de leyes
     */
  public function index(Request $request)
{
    $query = Ley::where('is_public', true);
    
    // Buscador
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title_es', 'like', "%{$search}%")
              ->orWhere('code', 'like', "%{$search}%")
              ->orWhere('summary_es', 'like', "%{$search}%");
        });
    }
    
    // Filtros adicionales
    if ($request->has('type') && !empty($request->type)) {
        $query->where('type', $request->type);
    }
    
    if ($request->has('status') && !empty($request->status)) {
        $query->where('status', $request->status);
    }
    
    $leyes = $query->orderBy('created_at', 'desc')->paginate(10);
    
    // Estadísticas
    $stats = [
        'total' => Ley::where('is_public', true)->count(),
        'aprobadas' => Ley::where('is_public', true)->where('status', 'aprobada')->count(),
        'proyectos' => Ley::where('is_public', true)->where('type', 'proyecto')->count(),
        'en_discusion' => Ley::where('is_public', true)->where('status', 'en_discusion')->count(),
    ];
    
    return view('leyes.index', compact('leyes', 'stats'));
}

    private function checkPermission()
    {
        if (!auth()->check()) {
            abort(403, 'Debes iniciar sesión.');
        }
        
        if (!auth()->user()->isAdmin() && !auth()->user()->isEditor()) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }
    }

    /**
     * Página pública - Detalle de una ley
     */
    public function show($id)
    {
        $ley = Ley::with(['diputado', 'comision'])->findOrFail($id);
        
        // Incrementar contador de vistas
        $ley->increment('views');
        
        // Leyes relacionadas (sin usar category)
        $relacionadas = Ley::where('is_public', true)
            ->where('id', '!=', $ley->id)
            ->where('diputado_id', $ley->diputado_id)
            ->limit(4)
            ->get();
        
        return view('leyes.show', compact('ley', 'relacionadas'));
    }

    /**
     * Descargar PDF
     */
    public function download($id)
    {
        $ley = Ley::findOrFail($id);
        
        if ($ley->file_pdf) {
            $ley->increment('downloads');
            return response()->download(storage_path('app/public/' . $ley->file_pdf));
        }
        
        return back()->with('error', 'El archivo no está disponible');
    }

    // ============================================
    // MÉTODOS DE ADMINISTRACIÓN
    // ============================================

    public function adminIndex()
    {
        $leyes = Ley::with(['diputado', 'comision'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.leyes.index', compact('leyes'));
    }

    public function create()
    {
        $diputados = Diputado::where('is_active', true)->orderBy('name')->get();
        $comisiones = Comision::where('is_active', true)->orderBy('name_es')->get();
        
        return view('admin.leyes.create', compact('diputados', 'comisiones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_es' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:leyes',
            'type' => 'required|in:ley,proyecto,resolucion,decreto',
            'status' => 'required|in:propuesta,en_discusion,aprobada,rechazada,archivada',
            'summary_es' => 'required|string',
            'content_es' => 'nullable|string',
            'presentation_date' => 'required|date',
            'approval_date' => 'nullable|date|after:presentation_date',
            'diputado_id' => 'required|exists:diputados,id',
            'comision_id' => 'nullable|exists:comisiones,id',
            'file_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'is_public' => 'boolean',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('file_pdf')) {
            $path = $request->file('file_pdf')->store('leyes', 'public');
            $data['file_pdf'] = $path;
        }

        Ley::create($data);

        return redirect()->route('admin.leyes.index')
            ->with('success', 'Ley creada correctamente');
    }

    public function edit($id)
    {
        $this->checkPermission();
        $ley = Ley::findOrFail($id);
        $diputados = Diputado::where('is_active', true)->orderBy('name')->get();
        $comisiones = Comision::where('is_active', true)->orderBy('name_es')->get();
        
        return view('admin.leyes.edit', compact('ley', 'diputados', 'comisiones'));
    }

    public function update(Request $request, $id)
    {
        $ley = Ley::findOrFail($id);

        $request->validate([
            'title_es' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:leyes,code,' . $id,
            'type' => 'required|in:ley,proyecto,resolucion,decreto',
            'status' => 'required|in:propuesta,en_discusion,aprobada,rechazada,archivada',
            'summary_es' => 'required|string',
            'content_es' => 'nullable|string',
            'presentation_date' => 'required|date',
            'approval_date' => 'nullable|date|after:presentation_date',
            'diputado_id' => 'required|exists:diputados,id',
            'comision_id' => 'nullable|exists:comisiones,id',
            'file_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'is_public' => 'boolean',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('file_pdf')) {
            if ($ley->file_pdf) {
                \Storage::disk('public')->delete($ley->file_pdf);
            }
            $path = $request->file('file_pdf')->store('leyes', 'public');
            $data['file_pdf'] = $path;
        }

        $ley->update($data);

        return redirect()->route('admin.leyes.index')
            ->with('success', 'Ley actualizada correctamente');
    }

    public function destroy($id)
    {
        $ley = Ley::findOrFail($id);
        
        if ($ley->file_pdf) {
            \Storage::disk('public')->delete($ley->file_pdf);
        }
        
        $ley->delete();

        return redirect()->route('admin.leyes.index')
            ->with('success', 'Ley eliminada correctamente');
    }
}