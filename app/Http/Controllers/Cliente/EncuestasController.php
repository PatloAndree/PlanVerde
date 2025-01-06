<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\EncuestaClientes;
use Illuminate\Http\Request;
use App\Models\Encuestas;
use Exception;
use Illuminate\Support\Carbon;

class EncuestasController extends Controller
{
    public function show(){
        $data['titulo'] = 'Encuestas';
        return view('cliente.encuestas',$data);
    }

    public function list(){
        $hoy = Carbon::today();
        $encuestasHoy = Encuestas::whereDate('fecha_inicio', '=', $hoy)->get();
        $encuestasCliente = EncuestaClientes::with('encuesta')->whereHas('encuesta', function ($query) use ($hoy) {
            $query->whereDate('fecha_inicio', '=', $hoy);
        })->get();

        $encuestasClienteIds = $encuestasCliente->pluck('encuesta_id')->toArray();
        $encuestasFinales = $encuestasHoy->filter(function ($encuesta) use ($encuestasClienteIds) {
            return !in_array($encuesta->id, $encuestasClienteIds);
        });

        $encuestasFinales = $encuestasFinales->merge($encuestasCliente->map(function ($encuestaCliente) {
            return $encuestaCliente->encuesta;
        }));

        $resultado = $encuestasFinales->map(function ($encuesta) use ($encuestasClienteIds) {
            // Verificar si la encuesta está en EncuestaCliente
            $encuestaCliente = EncuestaClientes::where('encuesta_id', $encuesta->id)->first();

            if ($encuestaCliente) {
                // Si existe en EncuestaCliente, devolver la información de EncuestaCliente
                return [
                    'id' => $encuestaCliente->id,
                    'empresa_id' => $encuestaCliente->empresa_id,
                    'user_id' => $encuestaCliente->user_id,
                    'encuesta_id' => $encuestaCliente->encuesta_id,
                    'encuesta_preguntas' => $encuestaCliente->encuesta_preguntas,
                    'encuesta_respuestas' => $encuestaCliente->encuesta_respuestas,
                    'notificado' => $encuestaCliente->notificado,
                    'status' => $encuestaCliente->status,
                    'created_at' => $encuestaCliente->created_at->format('d/m/Y H:i'),
                    'updated_at' => $encuestaCliente->updated_at,
                ];
            } else {
                // Si no existe en EncuestaCliente, devolver con status = 0 y created_at = null
                return [
                    'id' => null, // No tiene ID en EncuestaCliente
                    'empresa_id' => null, // Sin asociación a empresa
                    'user_id' => null, // Sin asociación a usuario
                    'encuesta_id' => $encuesta->id,
                    'encuesta_preguntas' => json_encode([
                        'titulo' => $encuesta->titulo,
                        'descripcion' => $encuesta->descripcion,
                        'contenido' => $encuesta->contenido,
                        'fecha_inicio' => $encuesta->fecha_inicio,
                    ]),
                    'encuesta_respuestas' => null, // Sin respuestas asociadas
                    'notificado' => 0, // Sin notificación
                    'status' => 2, // Status por defecto 0
                    'created_at' => null, // Sin fecha de creación
                    'updated_at' => null, // Sin fecha de actualización
                ];
            }
        });

        return ['data' => $resultado];
    }

    public function save(Request $request) {
        $request->validate([
            'encuestaclienteId' => 'required|integer|min:0',
            'encuestaId' => 'required|integer|exists:encuestas,id',
            'empresaId' => 'required|integer|exists:empresas,id',
            'clienteId' => 'required|integer|exists:users,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'preguntas' => 'required|array|min:1'
        ]);
        try {
            $encuesta = Encuestas::where('id',$request->encuestaId)->first();
            $dataEncuesta['empresa_id'] = $request->empresaId;
            $dataEncuesta['user_id'] = $request->clienteId;
            $dataEncuesta['encuesta_id'] = $request->encuestaId;
            $dataEncuesta['encuesta_preguntas'] = json_encode([
                'titulo' => $encuesta->titulo,
                'descripcion' => $encuesta->descripcion,
                'contenido' => $encuesta->contenido,
                'fecha_inicio' => $encuesta->fecha_inicio,
            ]);
            $dataEncuesta['encuesta_respuestas'] = json_encode([
                'titulo' => $encuesta->titulo,
                'descripcion' => $encuesta->descripcion,
                'contenido' => json_encode($request->preguntas),
                'fecha_inicio' => $encuesta->fecha_inicio,
            ]);
            $dataEncuesta['status'] = 1;

            $clienteEncuesta = EncuestaClientes::updateOrCreate(['id' => $request->encuestaclienteId],$dataEncuesta);
            return response()->json(['success' => true, 'message' => 'Encuesta realizada.', 'encuesta'=>$clienteEncuesta]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un problema.',
                'error' => $e->getMessage(),
            ], 500);
        }

    }

    public function editar($encuestaId,$encuestaClienteId){

        $encuesta = Encuestas::find($encuestaId);

        if (!$encuesta) {
            return response()->json(['error' => 'Encuesta no encontrada.'], 404);
        }

        $encuestaCliente = EncuestaClientes::find($encuestaClienteId);

        $user_id = auth()->id();
        $empresa_id = auth()->user()->empresa_id;

        if ($encuestaCliente) {
            $resultado = (object) [
                'id' => $encuestaCliente->id,
                'empresa_id' => $encuestaCliente->empresa_id,
                'user_id' => $encuestaCliente->user_id,
                'encuesta_id' => $encuestaCliente->encuesta_id,
                'encuesta_preguntas' => $encuestaCliente->encuesta_preguntas,
                'encuesta_respuestas' => $encuestaCliente->encuesta_respuestas,
                'notificado' => $encuestaCliente->notificado,
                'status' => $encuestaCliente->status,
                'created_at' => $encuestaCliente->created_at,
                'updated_at' => $encuestaCliente->updated_at,
            ];
        } else {
            $resultado = (object) [
                'id' => null, // No tiene ID en EncuestaClientes
                'empresa_id' => $empresa_id, // Toma el de la sesión si no existe
                'user_id' => $user_id, // Toma el del usuario en sesión
                'encuesta_id' => $encuesta->id,
                'encuesta_preguntas' => json_encode([
                    'titulo' => $encuesta->titulo,
                    'descripcion' => $encuesta->descripcion,
                    'contenido' => $encuesta->contenido,
                    'fecha_inicio' => $encuesta->fecha_inicio,
                ]),
                'encuesta_respuestas' => null, // Sin respuestas asociadas
                'notificado' => 0, // Sin notificación
                'status' => 0, // Status por defecto 0
                'created_at' => null, // Sin fecha de creación
                'updated_at' => null, // Sin fecha de actualización
            ];
        }


        return ['data' => $resultado];
    }
}
