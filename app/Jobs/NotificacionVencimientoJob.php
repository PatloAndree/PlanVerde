<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\NotificacionVencimientoMail;

use Illuminate\Support\Facades\Log;
use App\Models\Documents;
use App\Models\Empresas;
use App\Models\Pagos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;



class NotificacionVencimientoJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct($user_id,$diasAnterioresV)
    {
        $this->user_id = $user_id;
        $this->diasAnterioresV = $diasAnterioresV;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        Log::info('usuario arriba');
        $empresa = Empresas::where('id',$this->user_id)->first();
        Log::info($empresa);
            if($empresa){
                $pagoEmpresa = Pagos::where('empresa_id', $this->user_id)
                ->where(function ($query) {
                    $query->where('status', 1)
                            ->orWhere('status', 2);
                })
                ->where('fecha_inicio', '<=', now()->toDateString())
                ->where('fecha_fin', '>=', now()->toDateString())
                ->first();
                Log::info($pagoEmpresa);
                if($pagoEmpresa){

                    switch ($pagoEmpresa->status) {
                        case 1:
                            Mail::to(['carloszavaletaramirez@gmail.com','torresandreemail@gmail.com'])->send(new NotificacionVencimientoMail($empresa));
                            break;
                        case 2:
                            $fecha_inicio = Carbon::parse($pagoEmpresa->fecha_fin);
                            $fechaActual =  now();
                            $fecha_inicio->addDay($this->diasAnterioresV);
                            if($fecha_inicio->gt($fechaActual)){
                            Mail::to(['carloszavaletaramirez@gmail.com','torresandreemail@gmail.com'])->send(new NotificacionVencimientoMail($empresa));
                            }
                            break;
                    }

            }
        }
    }
}
