<?php

namespace App\Http\Controllers\Superadmin;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\Pagos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportesController extends Controller
{
    public function show(){
        $data['titulo'] = 'Reportes';
        return view('superadmin.reportes',$data);
    }

    public function dataIngresos(Request $request){
        try {
            $request->validate([
                'date' => 'required|string'
            ]);

            $rangoPago = $request->date;
            list($fechaInicioStr, $fechaFinStr) = explode(' a ', $rangoPago);
            $pagoFechaInicio = Carbon::createFromFormat('d/m/Y', trim($fechaInicioStr))->startOfDay();
            $pagoFechaFin = Carbon::createFromFormat('d/m/Y', trim($fechaFinStr))->endOfDay();

            $dataPagados = [];
            $dataPendientes = [];

            $currentDate = $pagoFechaInicio->copy();
            while ($currentDate <= $pagoFechaFin) {
                $pagadosQuery = Pagos::where('status', 1)->whereDate('created_at', $currentDate->format('Y-m-d'));
                $pendientesQuery = Pagos::where('status', 2)->whereDate('created_at', $currentDate->format('Y-m-d'));

                $dataPagados[] = [
                    'cantidad' => $pagadosQuery->count(),
                    'monto' => $pagadosQuery->sum('monto')
                ];

                $dataPendientes[] = [
                    'cantidad' => $pendientesQuery->count(),
                    'monto' => $pendientesQuery->sum('monto')
                ];

                $currentDate->addDay();
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'dates' => GeneralHelper::generateDateRange($pagoFechaInicio, $pagoFechaFin),
                    'pagados' => $dataPagados,
                    'pendientes' => $dataPendientes,
                ]
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
