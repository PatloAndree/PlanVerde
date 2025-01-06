<?php

use App\Models\Configuracion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('configuracion', function (Blueprint $table) {
            $table->id();
            $table->text('logo');
            $table->text('favicon');
            $table->string('nombre');
            $table->string('telefono');
            $table->string('documento');
            $table->text('direccion');
            $table->string('correo');
            $table->text('implementacion_drive_config')->nullable();
            $table->time('notificacion_vencimiento_hora_ejecucion');
            $table->integer('notificacion_vencimiento_dias_previos');
            $table->integer('notificacion_vencimiento_dias_posteriores');
            $table->string('notificacion_vencimiento_mensaje')->nullable();
            $table->time('notificacion_actividades_hora_ejecucion');
            $table->integer('notificacion_actividades_dias_previos');
            $table->timestamps();
        });

        Configuracion::create([
            'logo' => 'logo.png',
            'favicon' => 'favicon.ico',
            'nombre' => 'Nombre de la empresa',
            'telefono' => '999999999',
            'documento' => '10101010101',
            'direccion' => 'direccion',
            'correo' => 'admin@planverde.com',
            'notificacion_vencimiento_hora_ejecucion' => '00:00:00',
            'notificacion_vencimiento_dias_previos' => 5,
            'notificacion_vencimiento_dias_posteriores' => 3,
            'notificacion_actividades_hora_ejecucion' => '00:00:00',
            'notificacion_actividades_dias_previos' => 2
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracion');
    }
};
