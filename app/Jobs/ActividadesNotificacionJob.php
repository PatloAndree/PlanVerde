<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Mail\ActividadesMail;
use App\Models\Actividades;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ActividadesNotificacionJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct($hora, $diasPrevios)
    {
        $this->hora = $hora;
        $this->diasPrevios = $diasPrevios;
    }
    /**
     * Execute the job.
     */

    public function handle(): void
    {
        $now = Carbon::now();
        Log::info('Entrando a actividades !!');
        $diasPreviosG = $now->copy()->addDays($this->diasPrevios);

        $actividades = Actividades::whereBetween('fecha_inicio', [$diasPreviosG])
            ->where('sw_notificado', '!=', 1)
            ->get();
            Log::info('No hay nadaaa');

        if ($actividades->isNotEmpty()) {
            Mail::to(['carloszavaletaramirez@gmail.com', 'torresandreemail@gmail.com'])->send(new ActividadesMail($actividades));

            foreach ($actividades as $actividad) {
                $actividad->sw_notificado = 1;
                $actividad->save();
            }
        }
    }
}
