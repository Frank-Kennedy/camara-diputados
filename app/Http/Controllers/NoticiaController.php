<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Models\GaleriaImagen;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NoticiaController extends Controller
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
    // PÁGINA PÚBLICA - LISTA DE NOTICIAS
    // ============================================
    public function index(Request $request)
    {
        $query = Noticia::where('is_published', true);
        
        // Buscador
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title_es', 'like', "%{$search}%")
                  ->orWhere('summary_es', 'like', "%{$search}%")
                  ->orWhere('content_es', 'like', "%{$search}%");
            });
        }
        
        // Filtro por categoría
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }
        
        $noticias = $query->orderBy('published_date', 'desc')->paginate(9);
        
        $destacadas = Noticia::where('is_published', true)
            ->where('is_featured', true)
            ->orderBy('published_date', 'desc')
            ->limit(3)
            ->get();
        
        return view('noticias.index', compact('noticias', 'destacadas'));
    }

    // ============================================
    // PÁGINA PÚBLICA - DETALLE DE NOTICIA
    // ============================================
    public function show($slug)
    {
        $noticia = Noticia::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
        
        $noticia->increment('views');
        
        $relacionadas = Noticia::where('is_published', true)
            ->where('id', '!=', $noticia->id)
            ->where('category', $noticia->category)
            ->orderBy('published_date', 'desc')
            ->limit(4)
            ->get();
        
        return view('noticias.show', compact('noticia', 'relacionadas'));
    }

    // ============================================
    // ADMIN - LISTA DE NOTICIAS
    // ============================================
    public function adminIndex()
    {
        $this->checkPermission();
        $noticias = Noticia::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.noticias.index', compact('noticias'));
    }

    // ============================================
    // ADMIN - CREAR NOTICIA (FORMULARIO)
    // ============================================
    public function create()
    {
        $this->checkPermission();
        return view('admin.noticias.create');
    }

    // ============================================
    // ADMIN - GUARDAR NOTICIA
    // ============================================
    public function store(Request $request)
    {
        $this->checkPermission();
        
        $request->validate([
            'title_es' => 'required|string|max:255',
            'summary_es' => 'required|string',
            'content_es' => 'required|string',
            'category' => 'required|in:institucional,legislativo,eventos,comunicados,internacional',
            'published_date' => 'required|date',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title_es);
        $data['user_id'] = auth()->id();
        
        // Verificar slug único
        $count = Noticia::where('slug', $data['slug'])->count();
        if ($count > 0) {
            $data['slug'] = $data['slug'] . '-' . time();
        }

        // Subir imagen
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('noticias', 'public');
            $data['featured_image'] = $path;
        }

        Noticia::create($data);

        return redirect()->route('admin.noticias.index')
            ->with('success', 'Noticia creada correctamente');
    }

    // ============================================
    // ADMIN - EDITAR NOTICIA (FORMULARIO)
    // ============================================
    public function edit($id)
    {
        $this->checkPermission();
        $noticia = Noticia::findOrFail($id);
        return view('admin.noticias.edit', compact('noticia'));
    }

    // ============================================
    // ADMIN - ACTUALIZAR NOTICIA
    // ============================================
    public function update(Request $request, $id)
    {
        $this->checkPermission();
        $noticia = Noticia::findOrFail($id);

        $request->validate([
            'title_es' => 'required|string|max:255',
            'summary_es' => 'required|string',
            'content_es' => 'required|string',
            'category' => 'required|in:institucional,legislativo,eventos,comunicados,internacional',
            'published_date' => 'required|date',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = $request->all();

        // Actualizar slug si el título cambió
        if ($request->title_es !== $noticia->title_es) {
            $data['slug'] = Str::slug($request->title_es);
            $count = Noticia::where('slug', $data['slug'])->where('id', '!=', $id)->count();
            if ($count > 0) {
                $data['slug'] = $data['slug'] . '-' . time();
            }
        }

        // Subir nueva imagen
        if ($request->hasFile('featured_image')) {
            if ($noticia->featured_image) {
                \Storage::disk('public')->delete($noticia->featured_image);
            }
            $path = $request->file('featured_image')->store('noticias', 'public');
            $data['featured_image'] = $path;
        }

        $noticia->update($data);

        return redirect()->route('admin.noticias.index')
            ->with('success', 'Noticia actualizada correctamente');
    }

    // ============================================
    // ADMIN - PUBLICAR/DESPUBLICAR NOTICIA
    // ============================================
    public function togglePublish($id)
    {
        $this->checkPermission();
        $noticia = Noticia::findOrFail($id);
        $noticia->is_published = !$noticia->is_published;
        $noticia->save();

        $status = $noticia->is_published ? 'publicada' : 'despublicada';
        return redirect()->route('admin.noticias.index')
            ->with('success', "Noticia {$status} correctamente");
    }

    // ============================================
    // ADMIN - ELIMINAR NOTICIA
    // ============================================
    public function destroy($id)
    {
        $this->checkPermission();
        $noticia = Noticia::findOrFail($id);
        
        if ($noticia->featured_image) {
            \Storage::disk('public')->delete($noticia->featured_image);
        }
        
        $noticia->delete();

        return redirect()->route('admin.noticias.index')
            ->with('success', 'Noticia eliminada correctamente');
    }

    // ============================================
    // UPLOAD DE IMÁGENES PARA EL EDITOR
    // ============================================
    public function uploadImage(Request $request)
    {
        $this->checkPermission();
        
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
            ]);
            
            $name = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('noticias/editor/' . date('Y/m'), $name, 'public');
            
            return response()->json([
                'location' => asset('storage/' . $path)
            ]);
        }
        
        return response()->json(['error' => 'No se pudo subir la imagen'], 400);
    }
}