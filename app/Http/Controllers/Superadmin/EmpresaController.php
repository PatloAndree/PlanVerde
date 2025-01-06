<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Mail\CreateBusiness;
use App\Models\Documents;
use App\Models\Empresas;
use App\Models\Pagos;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;


class EmpresaController extends Controller
{
    public function show(){
        $data['titulo'] = 'Empresas';
        $data['documentos'] = Documents::where('status',1)->get();
        return view('superadmin.empresas',$data);
    }

    public function list(){
        $empresas = Empresas::with(['documento','usuario'])->where('status', '!=', 0)->get();
        return array("data"=>$empresas);
    }

    public function save(Request $request)
    {
        // Validar los datos recibidos
        try {
            $request->validate([
                'empresa_nombre' => 'required|string|max:255',
                'empresa_tipo_documento' => 'required|exists:documents,id',  // Valida que el tipo de documento exista en la tabla documentos
                'empresa_documento' => 'required|string|min:' . $this->getMinSize($request->empresa_tipo_documento) . '|max:' . $this->getMaxSize($request->empresa_tipo_documento),
                'empresa_email' => 'required|email|max:255',
                'empresa_telefono' => 'required|numeric|min:7',  // Mínimo 7 dígitos
                'empresa_direccion' => 'required|string|max:255',

                //PAGO
                'rangePago' => 'nullable|string',  // Puedes agregar una validación de fechas aquí
                'monto' => 'nullable|numeric',
                'status' => 'nullable|in:1,2',

                // Validaciones del administrador
                'administrador_nombres' => 'required|string|max:255',
                'administrador_apellidos' => 'required|string|max:255',
                'administrador_tipo_documento' => 'required|exists:documents,id',
                'administrador_documento' => 'required|string|min:' . $this->getMinSize($request->administrador_tipo_documento) . '|max:' . $this->getMaxSize($request->administrador_tipo_documento),
                'administrador_email' => 'required|email|max:255',
                'administrador_telefono' => 'required|numeric|min:7',
                'administrador_direccion' => 'required|string|max:255',
            ]);

            //EMPRESA
            $empresa = Empresas::updateOrCreate(
                ['id' => $request->empresa_id ? : null],  // Si es 0, se pasa null para evitar problemas
                [
                    'nombre' => $request->empresa_nombre,
                    'document_id' => $request->empresa_tipo_documento,
                    'document_number' => $request->empresa_documento,
                    'email' => $request->empresa_email,
                    'telefono' => $request->empresa_telefono,
                    'direccion' => $request->empresa_direccion
                ]
            );

            //USUARIO ADMIN
            $usuarioData = [
                'name' => $request->administrador_nombres,
                'last_name' => $request->administrador_apellidos,
                'document_id' => $request->administrador_tipo_documento,
                'document_number' => $request->administrador_documento,
                'telefono' => $request->administrador_telefono,
                'direccion' => $request->administrador_direccion,
                'email' => $request->administrador_email,
                'empresa_id' => $empresa->id,
            ];
            $randomPass='';
            if ($request->administrador_id == 0) {
                $randomPass = Str::random(10); // Generar una contraseña aleatoria
                $usuarioData['password'] = bcrypt($randomPass); // Asignar la contraseña al arreglo
            }
            $usuario = User::updateOrCreate(
                ['id' => $request->administrador_id],
                $usuarioData
            );
            $usuario->assignRole('cliente');
            $empresa->user_id = $usuario->id;
            $empresa->save();


            //PAGOS
            $message="Datos actualizados.";
            if($request->empresa_id==0 && $request->administrador_id == 0){
                $message="Empresa creada con éxito.";
                $rangoPago = $request->rangePago;
                list($fechaInicioStr, $fechaFinStr) = explode(' a ', $rangoPago);
                $pagoFechaInicio = Carbon::createFromFormat('d/m/Y', $fechaInicioStr)->format('Y-m-d');
                $pagoFechaFin = Carbon::createFromFormat('d/m/Y', $fechaFinStr)->format('Y-m-d');

                Pagos::create(
                    [
                        'empresa_id' => $empresa->id,
                        'user_id' => $usuario->id,
                        'fecha_inicio' => $pagoFechaInicio,
                        'fecha_fin' => $pagoFechaFin,
                        'fecha_pago' => Carbon::now(),
                        'monto' => $request->monto,
                        'status' => $request->status
                    ]
                );
                //ENVIAR CORREO AL USUARIO DE BIENVENIDA
                Mail::to($request->administrador_email)->send(new CreateBusiness($empresa, $pagoFechaInicio, $pagoFechaFin, $randomPass, $usuario));
            }

            return response()->json(['success' => true, 'message' => $message]);

        } catch (ValidationException $e) {
            // Retornar una respuesta personalizada
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors' => $e->errors()
            ], 422);
        }


    }

    private function getMinSize($tipoDocumentoId)
    {
        $documento = Documents::find($tipoDocumentoId);
        return $documento ? $documento->min_size : 0;
    }

    private function getMaxSize($tipoDocumentoId)
    {
        $documento = Documents::find($tipoDocumentoId);
        return $documento ? $documento->max_size : 255;
    }

    public function data($id){
        $empresa = Empresas::with(['documento', 'usuario','ultimoPago'])->findOrFail($id);
        return response()->json($empresa);
    }

    public function delete($id){
        $empresa = Empresas::find($id);
        if (!$empresa) {
            return response()->json([
                'success' => false,
                'message' => 'Empresa no encontrada.'
            ]);
        }
        $empresa->status = 0;
        $empresa->save();

        return response()->json([
            'success' => true,
            'message' => 'Empresa eliminada correctamente.'
        ]);
    }

    public function activate(Request $request){
        $empresa = Empresas::find($request->id);
        if (!$empresa) {
            return response()->json([
                'success' => false,
                'message' => 'Empresa no encontrada.'
            ]);
        }
        $empresa->status = $request->checked == true ? '2' : '1';
        $empresa->save();

        $mensaje = $request->checked == true ? 'Bloqueado correctamente.' : 'Desbloqueado correctamente.';
        return response()->json([
            'success' => true,
            'message' => $mensaje
        ]);
    }
}
