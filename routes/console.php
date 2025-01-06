<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\ActividadesNotificacionJob;
  use App\Jobs\NotificacionVencimientoJob;
  use Illuminate\Support\Facades\Schedule;
  use Illuminate\Support\Facades\Log;
  use App\Jobs\SendEmailJob;
  use Illuminate\Support\Facades\Auth;
  use App\Models\Configuracion;

  //$vencimientoConfig = Configuracion::find(1);
  //Log::info('Configuraciones obtenidas:', ['vencimientoConfig' => $vencimientoConfig]);

  // $hora=$vencimientoConfig->notificacion_actividades_hora_ejecucion;
  // $diasPrevios = $vencimientoConfig->notificacion_actividades_dias_previos;

  // Schedule::job(new ActividadesNotificacionJob($hora,$diasPrevios))->dailyAt($hora);

//   $vencimientoConfig = Configuracion::first();

// if ($vencimientoConfig) {
//     Log::info('Configuraciones obtenidas:', ['vencimientoConfig' => $vencimientoConfig]);

//     $hora = $vencimientoConfig->notificacion_actividades_hora_ejecucion;
//     $diasPrevios = $vencimientoConfig->notificacion_actividades_dias_previos;

//     Schedule::job(new ActividadesNotificacionJob($hora, $diasPrevios))->dailyAt($hora);
// }



$user_id = 1;
Log::info("ID INfo");
Log::info($user_id);
$diasAnterioresV = 5;
Schedule::job(new NotificacionVencimientoJob($user_id,$diasAnterioresV))->daily('22:00');


// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

// Schedule::command('SendUpcomingActivitiesNotification')->everyMinute();
// Schedule::command('logCrear')->everyMinute();

// Schedule::call(function() {
//     Log::info('Probandoo AHORA |');
//   })->everyMinute();



//   Schedule::job(new SendEmailJob('torresandreemail@gmail.com'))->everyMinute();
  // Schedule::job(new SendEmailJob('example@gmail.com'))->everyMinute();