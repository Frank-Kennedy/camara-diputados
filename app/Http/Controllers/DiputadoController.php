<?php

namespace App\Http\Controllers;

use App\Models\Diputado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DiputadoController extends Controller
{
    /**
     * Verificar permisos de administrador/editor
     */
    private function checkPermission()
    {
        if (!auth()->check()) {
            abort(403, 'Debes iniciar sesión.');
        }
        
        if (!auth()->user()->isAdmin() && !auth()->user()->isEditor()) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }
    }

    // ============================================
    // PÁGINA PÚBLICA - LISTA DE DIPUTADOS
    // ============================================
    public function index(Request $request)
    {
        $query = Diputado::where('is_active', true);
        
        // Buscador
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('political_party', 'like', "%{$search}%")
                  ->orWhere('constituency', 'like', "%{$search}%");
            });
        }
        
        $diputados = $query->orderBy('name')->paginate(12);
        
        return view('diputados.index', compact('diputados'));
    }

    // ============================================
    // PÁGINA PÚBLICA - DETALLE DE DIPUTADO
    // ============================================
    public function show($id)
    {
        $diputado = Diputado::with('comisiones')->findOrFail($id);
        $diputado->increment('views');
        
        return view('diputados.show', compact('diputado'));
    }

    // ============================================
    // ADMIN - LISTA DE DIPUTADOS
    // ============================================
    public function adminIndex(Request $request)
    {
        $this->checkPermission();
        
        $query = Diputado::query();
        
        // Buscador
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('political_party', 'like', "%{$search}%");
            });
        }
        
        // Filtro por estado
        if ($request->has('status') && !empty($request->status)) {
            $query->where('is_active', $request->status == 'active');
        }
        
        $diputados = $query->orderBy('name')->paginate(15);
        
        return view('admin.diputados.index', compact('diputados'));
    }

    // ============================================
    // ADMIN - CREAR DIPUTADO (FORMULARIO)
    // ============================================
    public function create()
    {
        $this->checkPermission();
        return view('admin.diputados.create');
    }

    // ============================================
    // ADMIN - GUARDAR DIPUTADO
    // ============================================
    public function store(Request $request)
    {
        $this->checkPermission();
        
        $request->validate([
            'name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:diputados',
            'phone' => 'nullable|string|max:50',
            'political_party' => 'required|string|max:100',
            'constituency' => 'required|string|max:100',
            'position' => 'nullable|string|max:100',
            'biography_es' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_active' => 'boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('diputados', 'public');
            $data['photo'] = $path;
        }

        Diputado::create($data);

        return redirect()->route('admin.diputados.index')
            ->with('success', 'Diputado creado correctamente');
    }

    // ============================================
    // ADMIN - EDITAR DIPUTADO (FORMULARIO)
    // ============================================
    public function edit($id)
    {
        $this->checkPermission();
        $diputado = Diputado::findOrFail($id);
        return view('admin.diputados.edit', compact('diputado'));
    }

    // ============================================
    // ADMIN - ACTUALIZAR DIPUTADO
    // ============================================
    public function update(Request $request, $id)
    {
        $this->checkPermission();
        $diputado = Diputado::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:diputados,email,' . $id,
            'phone' => 'nullable|string|max:50',
            'political_party' => 'required|string|max:100',
            'constituency' => 'required|string|max:100',
            'position' => 'nullable|string|max:100',
            'biography_es' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_active' => 'boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('photo')) {
            if ($diputado->photo) {
                Storage::disk('public')->delete($diputado->photo);
            }
            $path = $request->file('photo')->store('diputados', 'public');
            $data['photo'] = $path;
        }

        $diputado->update($data);

        return redirect()->route('admin.diputados.index')
            ->with('success', 'Diputado actualizado correctamente');
    }

    // ============================================
    // ADMIN - ELIMINAR DIPUTADO
    // ============================================
    public function destroy($id)
    {
        $this->checkPermission();
        $diputado = Diputado::findOrFail($id);
        
        if ($diputado->photo) {
            Storage::disk('public')->delete($diputado->photo);
        }
        
        $diputado->delete();

        return redirect()->route('admin.diputados.index')
            ->with('success', 'Diputado eliminado correctamente');
    }

    // ============================================
    // ADMIN - ACTIVAR/DESACTIVAR DIPUTADO
    // ============================================
    public function toggleStatus($id)
    {
        $this->checkPermission();
        $diputado = Diputado::findOrFail($id);
        $diputado->is_active = !$diputado->is_active;
        $diputado->save();

        $status = $diputado->is_active ? 'activado' : 'desactivado';
        return redirect()->route('admin.diputados.index')
            ->with('success', "Diputado {$status} correctamente");
    }
}