<?php

namespace App\Http\Controllers\Soporte;

use App\Http\Controllers\Controller;
use App\Models\EncuestaClientes;
use Illuminate\Http\Request;
use App\Models\Faqs;
use Exception;
use Illuminate\Support\Carbon;

class FaqsController extends Controller
{
    public function show(){
        $data['titulo'] = 'Preguntas frecuentes';
        return view('soporte.preguntasFaqs',$data);
    }

    public function list(){
        $faqs = Faqs::where('status', 1)->get();
        return ['data' => $faqs];
    }

    public function editar($id){
        $faqs = Faqs::where('id', $id)->where('status', 1)->first();
        return ['data' => $faqs];
    }


    public function save(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'pregunta' => 'required|string|max:255',
            'respuesta' => 'required|string',
            'preguntaId' => 'nullable|integer', // Validar que el ID sea numérico o nulo
        ]);

        try {
            if ($request->input('preguntaId')) {
                // Si preguntaId existe, buscar el registro
                $pregunta = Faqs::find($request->input('preguntaId'));

                if (!$pregunta) {
                    return response()->json([
                        'message' => 'La pregunta con el ID proporcionado no existe.',
                    ], 404);
                }

                // Actualizar el registro existente
                $pregunta->pregunta = $validated['pregunta'];
                $pregunta->respuesta = $validated['respuesta'];
                $pregunta->save();

                $message = 'Pregunta actualizada exitosamente.';
            } else {
                // Si no existe preguntaId, crear un nuevo registro
                $pregunta = new Faqs();
                $pregunta->pregunta = $validated['pregunta'];
                $pregunta->respuesta = $validated['respuesta'];
                $pregunta->save();

                $message = 'Pregunta guardada exitosamente.';
            }

            // Respuesta exitosa
            return response()->json([
                'message' => $message,
                'data' => $pregunta,
            ], 200);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json([
                'message' => 'Hubo un error al procesar la solicitud.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function delete($id)
    {
        try {
            $faqs = Faqs::findOrFail($id);

            $faqs->status = 0;
            $faqs->save();

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
        $imagen = ActividadesFotos::find($id);

        if ($imagen) {
            $imagen->delete(); // Eliminar la imagen de la base de datos
            // Storage::delete($imagen->ruta);

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false], 404);
        }
    }

}
