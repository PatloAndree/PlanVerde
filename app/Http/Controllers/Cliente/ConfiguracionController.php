<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Configuracion;
use Exception;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function show(){
        $data['titulo'] = 'Configuraciones';
        $data['empresa'] = Configuracion::where('id',1)->first();
        return view('cliente.configuracion',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'ruc' => 'required|string|max:20',
            'telefono' => 'required|string|max:15',
            'correo' => 'required|email',
            'direccion' => 'required|string|max:255',
            'logotipo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'implementacion_googledrive' => 'nullable|string',
            'vencimiento_ejecucion' => 'required|string',
            'vencimiento_dias_previos' => 'required|integer|min:0|max:10',
            'vencimiento_dias_posteriores' => 'required|integer|min:0|max:10',
            'vencimiento_mensaje' => 'nullable|string',
            'actividad_ejecucion' => 'required|string',
            'actividad_dias_previos' => 'required|integer|min:0|max:10'
        ]);

        try {
            $configuracion = Configuracion::firstOrNew(['id' => 1]);
            // Guardar los archivos si se suben
            $configuracion->nombre = $request->titulo;
            $configuracion->documento = $request->ruc;
            $configuracion->telefono = $request->telefono;
            $configuracion->correo = $request->correo;
            $configuracion->direccion = $request->direccion;

            if($request->file('logotipo')){
                $logotipo = $request->file('logotipo');
                $extensionLogo = $logotipo->getClientOriginalExtension();
                $fileNameLogo = 'logo'.'.'.$extensionLogo;
                $logotipo->storeAs('img', $fileNameLogo);
                $configuracion->logo = $fileNameLogo;
            }
            if($request->file('favicon')){
                $favicon = $request->file('favicon');
                $extensionFavicon = $favicon->getClientOriginalExtension();
                $fileNameFavicon = 'favicon'.'.'.$extensionFavicon;
                $favicon->storeAs('img', $fileNameFavicon);
                $configuracion->favicon = $fileNameFavicon;
            }

            $configuracion->implementacion_drive_config = trim($request->implementacion_googledrive);
            $configuracion->notificacion_vencimiento_hora_ejecucion = $request->vencimiento_ejecucion;
            $configuracion->notificacion_vencimiento_dias_previos = $request->vencimiento_dias_previos;
            $configuracion->notificacion_vencimiento_dias_posteriores = $request->vencimiento_dias_posteriores;
            $configuracion->notificacion_vencimiento_mensaje = $request->vencimiento_mensaje;
            $configuracion->notificacion_actividades_hora_ejecucion = $request->actividad_ejecucion;
            $configuracion->notificacion_actividades_dias_previos = $request->actividad_dias_previos;

            $configuracion->save();

            return response()->json([
                'success' => true,
                'message' => 'Datos actualizados.',
                'data' => $configuracion
            ]);
        } catch (Exception $e) {
            // Manejar el error
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un problema.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
