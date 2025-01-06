<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\EncuestaClientes;
use Illuminate\Http\Request;
use App\Models\Tickets;
use App\Models\Foros;
use App\Models\RespuestaForos;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ForoController extends Controller
{
    public function show()
    {
        $data['titulo'] = 'Foros';
        return view('marketing.foro', $data);
    }

    public function showCliente()
    {
        $data['titulo'] = 'Mis Foros';
        return view('clientes.foros', $data);
    }

    public function save(Request $request)
    {
        try {

            if (!empty($request->input('foroId'))) {
                $foro = Foros::find($request->foroId);
                if (!$foro) {
                    return response()->json(
                        [
                            'success' => false,
                            'message' => 'Usuario no encontrado.',
                        ],
                        404,
                    );
                }
                $request->validate([
                    'titulo' => 'nullable|string|max:255',
                    'descropcion' => 'nullable|string|max:255',
                ]);

                $foroData = [
                    'titulo' => $request->titulo,
                    'descripcion' => $request->descripcion,
                ];
                $foro->update($foroData);

                return response()->json([
                    'success' => true,
                    'message' => 'foro actualizado correctamente',
                    'data' => $foro,
                ]);
            } else {
                $request->validate([
                    'titulo' => 'nullable|string|max:255',
                    'descropcion' => 'nullable|string|max:255',
                ]);

                $foroData = [
                    'titulo' => $request->titulo,
                    'descripcion' => $request->descripcion,
                ];

                $foro = Foros::create($foroData);
              
                return response()->json([
                    'success' => true,
                    'message' => 'Foro creado correctamente',
                    'data' => $foro,
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error en la validación, por favor intente de nuevo.',
                    'errors' => $e->errors(),
                ],
                422,
            );
        
        }
    }

    public function saveRespuesta(Request $request)
    {
        $fecha_cierre = Carbon::now();

        // Validar los datos enviados
        $validated = $request->validate([
            'foroId' => 'required|integer', // Verificar que el foro existe
            'respuesta' => 'required|string|max:5000', // Validar la longitud del mensaje
            'respuestaId' => 'nullable|integer|', // ID de la respuesta para editar
        ]);

        try {
            if (!empty($validated['respuestaId'])) {
                // Editar una respuesta existente
                $respuesta = RespuestaForos::where('id', $validated['respuestaId'])
                    ->where('user_id', auth()->id()) // Asegurarse de que el usuario es el dueño
                    ->firstOrFail();

                $respuesta->update([
                    'mensaje' => $validated['respuesta'],
                ]);

                $message = 'Respuesta actualizada exitosamente.';
            } else {
                // Crear una nueva respuesta
                $respuesta = RespuestaForos::create([
                    'user_id' => auth()->id(),
                    'foro_id' => $validated['foroId'],
                    'mensaje' => $validated['respuesta'],
                    'status' => 1, // Estado inicial, por ejemplo "activo"
                ]);

                // Actualizar el estado del foro
                $foro = Foros::findOrFail($validated['foroId']);
                $foro->update([
                    'status' => 2,
                    'fecha_cierre' => $fecha_cierre,
                ]);

                $message = 'Respuesta guardada exitosamente y estado del foro actualizado.';
            }

            return response()->json([
                'message' => $message,
                'data' => $respuesta,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al guardar o actualizar la respuesta.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function list(){
        $foros = Foros::orderBy('created_at', 'desc')->get();
        return ['data' => $foros];
    }

    public function editar($id){
        $foro = Foros::findOrFail($id);
        return ['data' => $foro];
    }

    public function editarRespuesta($id)
    {
        $data['foro'] = Foros::findOrFail($id); // Obtén el foro
    
        $data['respuestas'] = RespuestaForos::with('user') // Relación con el usuario
        ->where('foro_id', $id) // Filtrar por ID del foro
        ->where('status', 1) // Filtrar respuestas con status == 1
        ->get();

    
        return view('clientes.forosRespuestas', $data);

    }
  
    public function delete($id)
    {
        try {
            $actividad = Foros::findOrFail($id);

            $actividad->status = 0;
            $actividad->save();

            return response()->json([
                'success' => true,
                'message' => 'Foro eliminada correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al intentar eliminar la actividad',
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $respuesta = RespuestaForos::findOrFail($id);

            $respuesta->status = 0;
            $respuesta->save();

            return response()->json([
                'success' => true,
                'message' => 'Eliminado correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al intentar eliminar',
            ]);
        }
    }
}