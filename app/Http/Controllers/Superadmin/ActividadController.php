<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Actividades;
use App\Models\ActividadesFotos;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ActividadController extends Controller
{
    public function listado()
    {
        $actividades = Actividades::with('ActividadesFotos')->get(); // Si quieres incluir las fotos relacionadas
        return response()->json($actividades);
    }

    public function show()
    {
        $data['actividades'] = Actividades::with('ActividadesFotos')->where('status', 1)->get();
        return view('superadmin.actividades', $data);
    }

    public function list()
    {
        // $usuarios = User::where('status', '!=', 0)->get()-order;
        $usuarios = User::orderBy('created_at', 'desc')->get();

        return ['data' => $usuarios];
    }

    public function edit(Request $request, $id)
    {
        $usuario = User::findOrFail($id); // Encuentra el usuario por ID o lanza un error 404
        return response()->json($usuario);
    }

    public function save(Request $request)
    {
        $user = auth()->user()->id;
        try {
            if ($request->has('actividad_id_edit')) {
                $actividad = Actividades::find($request->actividad_id_edit);

                if (!$actividad) {
                    return response()->json(
                        [
                            'success' => false,
                            'message' => 'Actividad no encontrada.',
                        ],
                        404,
                    );
                }

                $request->validate([
                    'titulo_edit' => 'nullable|string|max:255',
                    'tipo_edit' => 'required|integer',
                    'descripcion_edit' => 'nullable|string',
                    'fecha_inicio_edit' => 'required|date',
                    'fecha_fin_edit' => 'required|date|after_or_equal:fecha_inicio',
                ]);

                $actividadData = [
                    'user_id' => $user,
                    'titulo' => $request->titulo_edit,
                    'tipo' => $request->tipo_edit,
                    'descripcion' => $request->descripcion_edit,
                    'fecha_inicio' => $request->fecha_inicio_edit,
                    'fecha_final' => $request->fecha_fin_edit,
                ];

                $actividad->update($actividadData);

                if ($request->hasFile('image_edit')) {
                    foreach ($request->file('image_edit') as $image) {
                        if (!$image->isValid()) {
                            return response()->json(
                                [
                                    'success' => false,
                                    'message' => 'El archivo de imagen no es válido.',
                                ],
                                400,
                            );
                        }
    
                        $imagePath = $image->store('imagenes_actividades', 'public');
                        
                        ActividadesFotos::create([
                            'actividad_id' => $actividad->id,
                            'file_path' => $imagePath,
                        ]);
                    }
                }
    
                return response()->json([
                    'success' => true,
                    'message' => 'Actividad actualizada correctamente',
                    'data' => $actividad,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Actividad actualizada correctamente',
                    'data' => $actividad,
                ]);
            } else {
                $request->validate([
                    'titulo' => 'required|string|max:255',
                    'tipo' => 'required|integer',
                    'descripcion' => 'nullable|string',
                    'fecha_inicio' => 'required|date',
                    'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
                ]);

                $actividadData = [
                    'user_id' => $user,
                    'titulo' => $request->titulo,
                    'empresa_id' => 1,
                    'tipo' => $request->tipo,
                    'descripcion' => $request->descripcion,
                    'fecha_inicio' => $request->fecha_inicio,
                    'fecha_final' => $request->fecha_fin,
                ];

                $actividad = Actividades::create($actividadData);

                if ($request->hasFile('image')) {
                    foreach ($request->file('image') as $image) {
                        if (!$image->isValid()) {
                            return response()->json(
                                [
                                    'success' => false,
                                    'message' => 'El archivo de imagen no es válido.',
                                ],
                                400,
                            );
                        }

                        $imagePath = $image->store('imagenes_actividades', 'public');

                        ActividadesFotos::create([
                            'actividad_id' => $actividad->id,
                            'file_path' => $imagePath,
                        ]);
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Actividad creada correctamente',
                    'data' => $actividad,
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
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Este título de actividad ya está registrado. Por favor, utilice uno diferente.',
                    ],
                    409,
                );
            }

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Ocurrió un error al guardar los datos. Intente de nuevo.',
                ],
                500,
            );
        }
    }

    public function delete($id)
    {
        try {
            $actividad = Actividades::findOrFail($id);

            $actividad->status = 0;
            $actividad->save();

            return response()->json([
                'success' => true,
                'message' => 'Actividad eliminada correctamente',
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
