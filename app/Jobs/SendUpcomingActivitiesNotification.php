<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Mail\UpcomingActivitiesMail;
use App\Models\Actividades;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class SendUpcomingActivitiesNotification implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
        Log::info('numer prueba 0111 |');

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //HORA EN LA QUE SE EJEUCTA || CUANTO DIAS ANTES Y HASTA QUE POSTERIOR DIA ||
        $now = Carbon::now();
        Log::info('pruebita idid |'.$now);

        $fiveDaysLater = $now->copy()->addDays(5);
        Log::info('daddada AHORA |'. $fiveDaysLater);

        // Consultar actividades programadas en los próximos 5 días
        $actividades = Actividades::whereBetween('fecha_inicio', [$now, $fiveDaysLater])
            ->where('sw_notificado', '!=', 1) // Suponiendo que hay un campo status
            ->get();

        Log::info('daddada AHORA |'. $actividades);

        // Enviar un correo si hay actividades
        if ($actividades->isNotEmpty()) {
            // Aquí puedes enviar un correo a un usuario o a todos los usuarios interesados
            Mail::to(['carloszavaletaramirez@gmail.com','torresandreemail@gmail.com'])->send(new UpcomingActivitiesMail($actividades));
            /*'planverde2024@gmail.com',*/

            // Actualizar el estado de las actividades
            foreach ($actividades as $actividad) {
                $actividad->sw_notificado = 1; // Actualiza el estado
                $actividad->save();
            }
        }
    }
}
