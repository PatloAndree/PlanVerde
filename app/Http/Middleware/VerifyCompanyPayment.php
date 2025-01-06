<?php

namespace App\Http\Middleware;

use App\Models\Empresas;
use App\Models\Pagos;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyCompanyPayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::user();
        $empresa = Empresas::where('id',$user->empresa_id)->first();
        if($empresa){
            $pagoEmpresa = Pagos::where('empresa_id', $user->empresa_id)
            ->where(function ($query) {
                $query->where('status', 1)
                        ->orWhere('status', 2);
            })
            ->where('fecha_inicio', '<=', now()->toDateString())
            ->where('fecha_fin', '>=', now()->toDateString())
            ->first();
            $verifyPayment = false;
            if($pagoEmpresa){
                switch ($pagoEmpresa->status) {
                    case 1:
                        $verifyPayment = true;
                        break;
                    case 2:
                        $fecha_inicio = Carbon::parse($pagoEmpresa->fecha_inicio);
                        $fechaActual =  now();
                        $fecha_inicio->addDay(5);
                        if($fecha_inicio->gt($fechaActual)){
                            $verifyPayment = true;
                        }
                        break;
                }
            }
            if(!$verifyPayment){
                return redirect()->route('payment.blocked')->with('error', 'La empresa está bloqueada por falta de pago.');
            }

            //VERIFICACION DE ENCUESTA


        }
        return $next($request);

    }
}
