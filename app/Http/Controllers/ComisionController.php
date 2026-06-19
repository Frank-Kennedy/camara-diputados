<?php

namespace App\Http\Controllers;

use App\Models\Comision;
use Illuminate\Http\Request;

class ComisionController extends Controller
{
    /**
     * Verificar permisos
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
    // PÁGINA PÚBLICA - LISTA DE COMISIONES
    // ============================================
    public function index(Request $request)
    {
        $query = Comision::where('is_active', true);
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name_es', 'like', "%{$search}%")
                  ->orWhere('description_es', 'like', "%{$search}%");
            });
        }
        
        $comisiones = $query->orderBy('name_es')->paginate(10);
        
        return view('comisiones.index', compact('comisiones'));
    }

    // ============================================
    // ADMIN - LISTA DE COMISIONES
    // ============================================
    public function adminIndex(Request $request)
    {
        $this->checkPermission();
        
        $query = Comision::query();
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name_es', 'like', "%{$search}%")
                  ->orWhere('description_es', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('status') && !empty($request->status)) {
            $query->where('is_active', $request->status == 'active');
        }
        
        $comisiones = $query->orderBy('name_es')->paginate(15);
        
        return view('admin.comisiones.index', compact('comisiones'));
    }

    // ============================================
    // PÁGINA PÚBLICA - DETALLE DE COMISIÓN
    // ============================================
    public function show($id)
    {
        $comision = Comision::with('diputados')->findOrFail($id);
        return view('comisiones.show', compact('comision'));
    }

    // ============================================
    // ADMIN - CREAR COMISIÓN
    // ============================================
    public function create()
    {
        $this->checkPermission();
        return view('admin.comisiones.create');
    }

    // ============================================
    // ADMIN - GUARDAR COMISIÓN
    // ============================================
    public function store(Request $request)
    {
        $this->checkPermission();
        
        $request->validate([
            'name_es' => 'required|string|max:255',
            'name_fr' => 'nullable|string|max:255',
            'name_pt' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description_es' => 'required|string',
            'description_fr' => 'nullable|string',
            'description_pt' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('comisiones', 'public');
            $data['image'] = $path;
        }

        Comision::create($data);

        return redirect()->route('admin.comisiones.index')
            ->with('success', 'Comisión creada correctamente');
    }

    // ============================================
    // ADMIN - EDITAR COMISIÓN
    // ============================================
    public function edit($id)
    {
        $this->checkPermission();
        $comision = Comision::findOrFail($id);
        return view('admin.comisiones.edit', compact('comision'));
    }

    // ============================================
    // ADMIN - ACTUALIZAR COMISIÓN
    // ============================================
    public function update(Request $request, $id)
    {
        $this->checkPermission();
        $comision = Comision::findOrFail($id);

        $request->validate([
            'name_es' => 'required|string|max:255',
            'name_fr' => 'nullable|string|max:255',
            'name_pt' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description_es' => 'required|string',
            'description_fr' => 'nullable|string',
            'description_pt' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            if ($comision->image) {
                \Storage::disk('public')->delete($comision->image);
            }
            $path = $request->file('image')->store('comisiones', 'public');
            $data['image'] = $path;
        }

        $comision->update($data);

        return redirect()->route('admin.comisiones.index')
            ->with('success', 'Comisión actualizada correctamente');
    }

    // ============================================
    // ADMIN - ELIMINAR COMISIÓN
    // ============================================
    public function destroy($id)
    {
        $this->checkPermission();
        $comision = Comision::findOrFail($id);
        
        if ($comision->image) {
            \Storage::disk('public')->delete($comision->image);
        }
        
        $comision->delete();

        return redirect()->route('admin.comisiones.index')
            ->with('success', 'Comisión eliminada correctamente');
    }

    // ============================================
    // ADMIN - ACTIVAR/DESACTIVAR
    // ============================================
    public function toggleStatus($id)
    {
        $this->checkPermission();
        $comision = Comision::findOrFail($id);
        $comision->is_active = !$comision->is_active;
        $comision->save();

        $status = $comision->is_active ? 'activada' : 'desactivada';
        return redirect()->route('admin.comisiones.index')
            ->with('success', "Comisión {$status} correctamente");
    }
}
