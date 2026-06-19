<?php

namespace App\Http\Controllers;

use App\Models\Transparencia;
use Illuminate\Http\Request;

class TransparenciaController extends Controller
{
    /**
     * Página pública - Lista de documentos de transparencia
     */
    public function index(Request $request)
    {
        $query = Transparencia::where('is_public', true);
        
        // Buscador
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title_es', 'like', "%{$search}%")
                ->orWhere('description_es', 'like', "%{$search}%");
            });
        }
        
        // Filtro por categoría
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }
        
        // Filtro por año
        if ($request->has('year') && !empty($request->year)) {
            $query->where('year', $request->year);
        }
        
        $documentos = $query->orderBy('year', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        $categorias = [
            'presupuesto' => Transparencia::where('is_public', true)->where('category', 'presupuesto')->count(),
            'informe_gestion' => Transparencia::where('is_public', true)->where('category', 'informe_gestion')->count(),
            'rendicion_cuentas' => Transparencia::where('is_public', true)->where('category', 'rendicion_cuentas')->count(),
            'contrataciones' => Transparencia::where('is_public', true)->where('category', 'contrataciones')->count(),
            'planificacion' => Transparencia::where('is_public', true)->where('category', 'planificacion')->count(),
        ];
        
        $total = Transparencia::where('is_public', true)->count();
        
        return view('transparencia.index', compact('documentos', 'categorias', 'total'));
    }

    /**
     * Página pública - Detalle de un documento
     */
    public function show($id)
    {
        $documento = Transparencia::findOrFail($id);
        
        if (!$documento->is_public) {
            abort(404);
        }
        
        return view('transparencia.show', compact('documento'));
    }

    /**
     * Descargar archivo PDF
     */
    public function download($id)
    {
        $documento = Transparencia::findOrFail($id);
        
        if ($documento->file_pdf) {
            $documento->increment('downloads');
            return response()->download(storage_path('app/public/' . $documento->file_pdf));
        }
        
        return back()->with('error', 'El archivo no está disponible');
    }

    /**
     * Descargar archivo Excel
     */
    public function downloadExcel($id)
    {
        $documento = Transparencia::findOrFail($id);
        
        if ($documento->file_excel) {
            $documento->increment('downloads');
            return response()->download(storage_path('app/public/' . $documento->file_excel));
        }
        
        return back()->with('error', 'El archivo no está disponible');
    }

    // ============================================
    // ADMINISTRACIÓN
    // ============================================

    public function adminIndex()
    {
        $documentos = Transparencia::orderBy('year', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.transparencia.index', compact('documentos'));
    }

    public function create()
    {
        return view('admin.transparencia.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_es' => 'required|string|max:255',
            'title_fr' => 'nullable|string|max:255',
            'title_pt' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'category' => 'required|in:presupuesto,informe_gestion,rendicion_cuentas,contrataciones,planificacion',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'description_es' => 'nullable|string',
            'description_fr' => 'nullable|string',
            'description_pt' => 'nullable|string',
            'description_en' => 'nullable|string',
            'publication_date' => 'required|date',
            'file_pdf' => 'nullable|file|mimes:pdf|max:20480',
            'file_excel' => 'nullable|file|mimes:xls,xlsx|max:10240',
            'is_public' => 'boolean',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('file_pdf')) {
            $path = $request->file('file_pdf')->store('transparencia', 'public');
            $data['file_pdf'] = $path;
        }
        
        if ($request->hasFile('file_excel')) {
            $path = $request->file('file_excel')->store('transparencia', 'public');
            $data['file_excel'] = $path;
        }

        Transparencia::create($data);

        return redirect()->route('admin.transparencia.index')
            ->with('success', 'Documento creado correctamente');
    }

    public function edit($id)
    {
        $documento = Transparencia::findOrFail($id);
        return view('admin.transparencia.edit', compact('documento'));
    }

    public function update(Request $request, $id)
    {
        $documento = Transparencia::findOrFail($id);

        $request->validate([
            'title_es' => 'required|string|max:255',
            'title_fr' => 'nullable|string|max:255',
            'title_pt' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'category' => 'required|in:presupuesto,informe_gestion,rendicion_cuentas,contrataciones,planificacion',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'description_es' => 'nullable|string',
            'description_fr' => 'nullable|string',
            'description_pt' => 'nullable|string',
            'description_en' => 'nullable|string',
            'publication_date' => 'required|date',
            'file_pdf' => 'nullable|file|mimes:pdf|max:20480',
            'file_excel' => 'nullable|file|mimes:xls,xlsx|max:10240',
            'is_public' => 'boolean',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('file_pdf')) {
            if ($documento->file_pdf) {
                \Storage::disk('public')->delete($documento->file_pdf);
            }
            $path = $request->file('file_pdf')->store('transparencia', 'public');
            $data['file_pdf'] = $path;
        }
        
        if ($request->hasFile('file_excel')) {
            if ($documento->file_excel) {
                \Storage::disk('public')->delete($documento->file_excel);
            }
            $path = $request->file('file_excel')->store('transparencia', 'public');
            $data['file_excel'] = $path;
        }

        $documento->update($data);

        return redirect()->route('admin.transparencia.index')
            ->with('success', 'Documento actualizado correctamente');
    }

    public function destroy($id)
    {
        $documento = Transparencia::findOrFail($id);
        
        if ($documento->file_pdf) {
            \Storage::disk('public')->delete($documento->file_pdf);
        }
        if ($documento->file_excel) {
            \Storage::disk('public')->delete($documento->file_excel);
        }
        
        $documento->delete();

        return redirect()->route('admin.transparencia.index')
            ->with('success', 'Documento eliminado correctamente');
    }
}