<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Documents;
use App\Models\Empresas;
use App\Models\Pagos;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PagosController extends Controller
{
    public function show(){
        $data['titulo'] = 'Pagos';
        $data['documentos'] = Documents::where('status',1)->get();
        return view('superadmin.pagos',$data);
    }

    public function list(){
        $pagos = Pagos::with(['empresa','cliente'])->where('status','!=','0')->get();
        return array("data"=>$pagos);
    }

    public function data($id){
        $pago = Pagos::with(['empresa', 'cliente'])->findOrFail($id);
        return response()->json($pago);
    }

    public function dataEmpresa(Request $request){
        $empresas = Empresas::whereAny([
            'nombre',
            'document_number'
        ], 'like', '%'.$request->search.'%')->get();

        return $empresas;
    }

    public function dataUser($id){
        $users = User::where('empresa_id',$id)->get();
        return $users;
    }

    public function save(Request $request){
        try {
            $request->validate([
                'empresaID' => 'required|exists:empresas,id',

                'rangePago' => 'required|string',
                'monto' => 'required|numeric',
                'status' => 'required|in:1,2',

                'administrador_id' => 'required|exists:users,id',
            ]);

            $pago = Pagos::where('id',$request->pago_id)->first();
            $rangoPago = $request->rangePago;
            list($fechaInicioStr, $fechaFinStr) = explode(' a ', $rangoPago);
            $pagoFechaInicio = Carbon::createFromFormat('d/m/Y', $fechaInicioStr)->format('Y-m-d');
            $pagoFechaFin = Carbon::createFromFormat('d/m/Y', $fechaFinStr)->format('Y-m-d');

            $dataPago['empresa_id'] = $request->empresaID;
            $dataPago['user_id'] = $request->administrador_id;

            $dataPago['fecha_inicio'] = $pagoFechaInicio;
            $dataPago['fecha_fin'] = $pagoFechaFin;

            if(($request->status == 1 && $request->pago_id=='') || ($request->status == 1 && $pago && $pago->status==2)){
                $dataPago['fecha_pago'] = Carbon::now();
            }
            $dataPago['monto'] = $request->monto;
            $dataPago['status'] = $request->status;

            $pagos = Pagos::updateOrCreate(['id' => $request->administrador_id],
            $dataPago);

            return response()->json(['success' => true, 'message' => 'Pago guardado, correctamente.']);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors' => $e->errors()
            ], 422);
        }
    }
}
