<?php

namespace App\Http\Controllers;

use App\Models\Diputado;
use Illuminate\Http\Request;

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
    // MÉTODOS PÚBLICOS
    // ============================================

    public function index()
    {
        $diputados = Diputado::where('is_active', true)
            ->orderBy('name')
            ->paginate(12);
        
        return view('diputados.index', compact('diputados'));
    }

    public function show($id)
    {
        $diputado = Diputado::with('comisiones')->findOrFail($id);
        $diputado->increment('views');
        
        return view('diputados.show', compact('diputado'));
    }

    // ============================================
    // MÉTODOS DE ADMINISTRACIÓN
    // ============================================

    public function adminIndex()
    {
        $this->checkPermission();
        $diputados = Diputado::orderBy('name')->paginate(15);
        return view('admin.diputados.index', compact('diputados'));
    }

    public function create()
    {
        $this->checkPermission();
        return view('admin.diputados.create');
    }

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
            'is_active' => 'boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
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

    public function edit($id)
    {
        $this->checkPermission();
        $diputado = Diputado::findOrFail($id);
        return view('admin.diputados.edit', compact('diputado'));
    }

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
            'is_active' => 'boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('photo')) {
            if ($diputado->photo) {
                \Storage::disk('public')->delete($diputado->photo);
            }
            $path = $request->file('photo')->store('diputados', 'public');
            $data['photo'] = $path;
        }

        $diputado->update($data);

        return redirect()->route('admin.diputados.index')
            ->with('success', 'Diputado actualizado correctamente');
    }

    public function destroy($id)
    {
        $this->checkPermission();
        $diputado = Diputado::findOrFail($id);
        
        if ($diputado->photo) {
            \Storage::disk('public')->delete($diputado->photo);
        }
        
        $diputado->delete();

        return redirect()->route('admin.diputados.index')
            ->with('success', 'Diputado eliminado correctamente');
    }
}