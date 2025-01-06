<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Encuestas;


class EncuestasController extends Controller
{
    public function show(){
        $data['titulo'] = 'Encuestas';
        return view('superadmin.encuestas',$data);
    }

    public function list(){
        $encuestas = Encuestas::where('status', 1)->get();
        return ['data' => $encuestas];
    }

    public function save(Request $request) {
        // Validar los datos recibidos
        $data = $request->json()->all();

        // Si hay un ID en el request, buscar la encuesta; si no, crear una nueva
        $encuesta = isset($data['id']) ? Encuestas::find($data['id']) : new Encuestas();

        if (!$encuesta) {
            return response()->json(['message' => 'Encuesta no encontrada'], 404);
        }

        // Asignar datos al modelo (común para crear y editar)
        $encuesta->titulo = $data['titulo'];
        $encuesta->descripcion = $data['descripcion'];
        $encuesta->contenido = json_encode($data['preguntas']);
        $encuesta->fecha_inicio = $data['fecha_inicio'];

        // Guardar los cambios (crear o actualizar)
        $encuesta->save();

        // Retornar respuesta exitosa
        return response()->json([
            'message' => isset($data['id']) ? 'Encuesta actualizada con éxito' : 'Encuesta creada con éxito',
            'encuesta' => $encuesta
        ], isset($data['id']) ? 200 : 201);
    }


    public function editar($id){
        $encuesta = Encuestas::where('id', $id)->where('status', 1)->first();
        return ['data' => $encuesta];
    }

    public function destroy($id)
    {
        $encuesta = Encuestas::find($id);
        if (!$encuesta) {
            return response()->json(['success' => false, 'message' => 'Encuesta no encontrada.'], 404);
        }
        try {
            $encuesta->status = 0;
            $encuesta->save();
            return response()->json(['success' => true, 'message' => 'Encuesta eliminada correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar la encuesta.'], 500);
        }
    }

}
