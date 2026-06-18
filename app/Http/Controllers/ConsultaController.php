<?php

namespace App\Http\Controllers;

use App\Models\ConsultaCiudadana;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    /**
     * Mostrar el formulario de consulta ciudadana.
     */
    public function create()
    {
        return view('consulta.create');
    }

    /**
     * Guardar una nueva consulta.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject_es' => 'required|string|max:255',
            'type' => 'required|in:sugerencia,consulta,queja,solicitud,denuncia',
            'message_es' => 'required|string',
            'file_attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'is_anonymous' => 'boolean',
        ]);

        $data = $request->all();

        // Si es anónimo, no guardar nombre y email
        if ($request->has('is_anonymous') && $request->is_anonymous) {
            $data['name'] = 'Anónimo';
            $data['last_name'] = '';
            $data['email'] = 'anonimo@parlamentoge.qq';
        }

        // Manejar la subida del archivo
        if ($request->hasFile('file_attachment')) {
            $path = $request->file('file_attachment')->store('consultas', 'public');
            $data['file_attachment'] = $path;
        }

        // Asignar estado inicial
        $data['status'] = 'pendiente';

        ConsultaCiudadana::create($data);

        return redirect()->route('home')
            ->with('success', 'Tu consulta ha sido enviada correctamente. Te responderemos a la brevedad.');
    }

    /**
     * Panel de administración - Lista de consultas.
     */
    public function index()
    {
        $consultas = ConsultaCiudadana::orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.consultas.index', compact('consultas'));
    }

    /**
     * Ver detalle de una consulta.
     */
    public function show($id)
    {
        $consulta = ConsultaCiudadana::findOrFail($id);
        return view('admin.consultas.show', compact('consulta'));
    }

    /**
     * Responder a una consulta.
     */
    public function respond(Request $request, $id)
    {
        $request->validate([
            'response_es' => 'required|string',
        ]);

        $consulta = ConsultaCiudadana::findOrFail($id);
        $consulta->response_es = $request->response_es;
        $consulta->response_date = now();
        $consulta->status = 'resuelta';
        $consulta->user_id = auth()->id();
        $consulta->save();

        return redirect()->route('admin.consultas.index')
            ->with('success', 'Respuesta enviada correctamente');
    }

    /**
     * Cambiar estado de una consulta.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pendiente,en_proceso,resuelta,archivada',
        ]);

        $consulta = ConsultaCiudadana::findOrFail($id);
        $consulta->status = $request->status;
        $consulta->save();

        return redirect()->route('admin.consultas.index')
            ->with('success', 'Estado actualizado correctamente');
    }

    /**
     * Eliminar una consulta.
     */
    public function destroy($id)
    {
        $consulta = ConsultaCiudadana::findOrFail($id);
        
        if ($consulta->file_attachment) {
            \Storage::disk('public')->delete($consulta->file_attachment);
        }
        
        $consulta->delete();

        return redirect()->route('admin.consultas.index')
            ->with('success', 'Consulta eliminada correctamente');
    }
}
