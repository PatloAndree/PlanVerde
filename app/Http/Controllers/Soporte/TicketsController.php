<?php

namespace App\Http\Controllers\Soporte;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\EncuestaClientes;
use Illuminate\Http\Request;
use App\Models\Tickets;
use App\Models\DocumentoSoporte;
use App\Models\RespuestaTicket;

use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class TicketsController extends Controller
{
    public function show()
    {
        $data['titulo'] = 'Tickets';
        return view('soporte.tickets', $data);
    }

    public function list()
    {
        $Tickets = Tickets::where('status', 1)->get();
        return ['data' => $Tickets];
    }

    public function editar($id)
    {
        $ticket = Tickets::find($id);

        if (!$ticket) {
            return response()->json(
                [
                    'message' => 'El ticket no existe.',
                ],
                404,
            );
        }

        return response()->json(
            [
                'data' => [
                    'id' => $ticket->id,
                    'titulo' => $ticket->titulo,
                    'descripcion' => $ticket->descripcion,
                    'fecha_inicio' => $ticket->fecha_inicio,
                    'adjuntos' => $ticket->adjuntos ? Storage::url($ticket->adjuntos) : null,
                ],
            ],
            200,
        );
    }

    public function save3(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'ticketId' => 'nullable|integer',
        ]);

        try {
            // Verificar si es una actualización
            if ($request->input('ticketId')) {
                $ticket = Tickets::find($request->input('ticketId'));

                if (!$ticket) {
                    return response()->json(
                        [
                            'message' => 'El ticket con el ID proporcionado no existe.',
                        ],
                        404,
                    );
                }

                $message = 'Ticket actualizado exitosamente.';
            } else {
                // Crear un nuevo ticket
                $ticket = new Tickets();
                // Asignar datos comunes
                $ticket->titulo = $validated['titulo'];
                $ticket->descripcion = $validated['descripcion'];
                $ticket->save();

                // Manejar múltiples archivos adjuntos
                if ($request->hasFile('adjuntos')) {
                    foreach ($request->file('adjuntos') as $file) {
                        $filePath = $file->store('incidencias', 'public');
                        $documento = new DocumentoSoporte();
                        $documento->user_id = auth()->id(); // Asignar ID del usuario autenticado
                        $documento->ticket_id = $ticket->id; // Asignar el ID del ticket
                        $documento->nombre = $file->getClientOriginalName();
                        $documento->ruta = $filePath;
                        $documento->extension = $file->getClientOriginalExtension();
                        $documento->tipo = 1; // Cambiar según la lógica de tu aplicación
                        $documento->file_id = 'joa'; // Opcional
                        $documento->save();
                    }
                }
            }

            return response()->json(
                [
                    'message' => 'Creado correctamente',
                    'data' => $ticket,
                ],
                200,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'Hubo un error al procesar la solicitud.',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function save(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'adjuntos.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', // Validación de archivos
        ]);

        try {
            // Paso 1: Crear un nuevo ticket
            $ticket = new Tickets();
            $ticket->titulo = $validated['titulo'];
            $ticket->descripcion = $validated['descripcion'];
            $ticket->save();

            // Paso 2: Crear una respuesta al ticket
            $respuesta = new RespuestaTicket();
            $respuesta->ticket_id = $ticket->id;
            $respuesta->user_id = auth()->id(); // Usuario autenticado
            $respuesta->mensaje = 'Respuesta inicial para el ticket.';
            $respuesta->save();

            // Paso 3: Crear documentos de soporte usando el ID de la respuesta
            if ($request->hasFile('adjuntos')) {
                foreach ($request->file('adjuntos') as $file) {
                    $filePath = $file->store('incidencias', 'public');
                    $documento = new DocumentoSoporte();
                    $documento->user_id = auth()->id(); // Usuario autenticado
                    $documento->respuesta_tickets_id = auth()->id(); // Usuario autenticado
                    $documento->nombre = $file->getClientOriginalName();
                    $documento->ruta = $filePath;
                    $documento->extension = $file->getClientOriginalExtension();
                    $documento->tipo = 1; // Cambiar según la lógica de tu aplicación
                    $documento->save();
                }
            }

            return response()->json(
                [
                    'message' => 'Ticket, respuesta y documentos creados correctamente.',
                    'data' => [
                        'ticket' => $ticket,
                        'respuesta' => $respuesta,
                    ],
                ],
                200,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'Hubo un error al procesar la solicitud.',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function delete($id)
    {
        try {
            $Tickets = Tickets::findOrFail($id);

            $Tickets->status = 0;
            $Tickets->save();

            return response()->json([
                'success' => true,
                'message' => 'Pregunta eliminada correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al intentar eliminar la Pregunta',
            ]);
        }
    }

    public function destroy($id)
    {
        $imagen = Tickets::find($id);

        if ($imagen) {
            $imagen->delete(); // Eliminar la imagen de la base de datos
            // Storage::delete($imagen->ruta);

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false], 404);
        }
    }
}
