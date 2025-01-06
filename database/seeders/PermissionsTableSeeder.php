<?php

namespace Database\Seeders;

use App\Models\Empresas;
use App\Models\Pagos;
use App\Models\Planes;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permisos para la página de empresas
        Permission::create(['name' => 'empresas.show']);
        Permission::create(['name' => 'empresas.create']);
        Permission::create(['name' => 'empresas.edit']);
        Permission::create(['name' => 'empresas.delete']);
        Permission::create(['name' => 'empresas.activate']);

        Permission::create(['name' => 'pagos.show']);
        Permission::create(['name' => 'pagos.create']);
        Permission::create(['name' => 'pagos.edit']);

        Permission::create(['name' => 'reportes.show']);
        Permission::create(['name' => 'reportes.download']);

        Permission::create(['name' => 'actividades.show']);
        Permission::create(['name' => 'actividades.create']);
        Permission::create(['name' => 'actividades.edit']);
        Permission::create(['name' => 'actividades.delete']);
        Permission::create(['name' => 'actividades.activate']);

        Permission::create(['name' => 'estadisticas.show']);
        Permission::create(['name' => 'estadisticas.download']);

        Permission::create(['name' => 'configuracion.show']);
        Permission::create(['name' => 'configuracion.edit']);

        Permission::create(['name' => 'usuarios.show']);
        Permission::create(['name' => 'usuarios.edit']);
        Permission::create(['name' => 'usuarios.create']);
        Permission::create(['name' => 'usuarios.delete']);
        Permission::create(['name' => 'usuarios.activate']);

        Permission::create(['name' => 'documentos.show']);
        Permission::create(['name' => 'documentos.edit']);
        Permission::create(['name' => 'documentos.create']);
        Permission::create(['name' => 'documentos.delete']);
        Permission::create(['name' => 'documentos.activate']);

        Permission::create(['name' => 'notificaciones.show']);
        Permission::create(['name' => 'notificaciones.edit']);

        Permission::create(['name' => 'plantillas.create']);
        Permission::create(['name' => 'plantillas.show']);
        Permission::create(['name' => 'plantillas.edit']);
        Permission::create(['name' => 'plantillas.delete']);

        Permission::create(['name' => 'incidencias.create']);
        Permission::create(['name' => 'incidencias.show']);
        Permission::create(['name' => 'incidencias.edit']);
        Permission::create(['name' => 'incidencias.delete']);

        Permission::create(['name' => 'encuestas.create']);
        Permission::create(['name' => 'encuestas.show']);
        Permission::create(['name' => 'encuestas.edit']);
        Permission::create(['name' => 'encuestas.delete']);


        Permission::create(['name' => 'formatos.create']);
        Permission::create(['name' => 'formatos.show']);
        Permission::create(['name' => 'formatos.edit']);
        Permission::create(['name' => 'formatos.delete']);

        Permission::create(['name' => 'preguntasFaqs.create']);
        Permission::create(['name' => 'preguntasFaqs.show']);
        Permission::create(['name' => 'preguntasFaqs.edit']);
        Permission::create(['name' => 'preguntasFaqs.delete']);

        Permission::create(['name' => 'tickets.create']);
        Permission::create(['name' => 'tickets.show']);
        Permission::create(['name' => 'tickets.edit']);
        Permission::create(['name' => 'tickets.delete']);

        Permission::create(['name' => 'documentosSoporte.create']);
        Permission::create(['name' => 'documentosSoporte.show']);
        Permission::create(['name' => 'documentosSoporte.edit']);
        Permission::create(['name' => 'documentosSoporte.delete']);

        Permission::create(['name' => 'cotizaciones.create']);
        Permission::create(['name' => 'cotizaciones.show']);
        Permission::create(['name' => 'cotizaciones.edit']);
        Permission::create(['name' => 'cotizaciones.delete']);

        Permission::create(['name' => 'mensajes.create']);
        Permission::create(['name' => 'mensajes.show']);
        Permission::create(['name' => 'mensajes.edit']);
        Permission::create(['name' => 'mensajes.delete']);

        Permission::create(['name' => 'foro.create']);
        Permission::create(['name' => 'foro.show']);
        Permission::create(['name' => 'foro.edit']);
        Permission::create(['name' => 'foro.delete']);

        Permission::create(['name' => 'archivos.create']);
        Permission::create(['name' => 'archivos.show']);
        Permission::create(['name' => 'archivos.edit']);
        Permission::create(['name' => 'archivos.delete']);

        Permission::create(['name' => 'contactos.create']);
        Permission::create(['name' => 'contactos.show']);
        Permission::create(['name' => 'contactos.edit']);
        Permission::create(['name' => 'contactos.delete']);

        Permission::create(['name' => 'historial.create']);
        Permission::create(['name' => 'historial.show']);
        Permission::create(['name' => 'historial.edit']);
        Permission::create(['name' => 'historial.delete']);

        Permission::create(['name' => 'actas.create']);
        Permission::create(['name' => 'actas.show']);
        Permission::create(['name' => 'actas.edit']);
        Permission::create(['name' => 'actas.delete']);

        Permission::create(['name' => 'contratos.create']);
        Permission::create(['name' => 'contratos.show']);
        Permission::create(['name' => 'contratos.edit']);
        Permission::create(['name' => 'contratos.delete']);

        Permission::create(['name' => 'capacitaciones.create']);
        Permission::create(['name' => 'capacitaciones.show']);
        Permission::create(['name' => 'capacitaciones.edit']);
        Permission::create(['name' => 'capacitaciones.delete']);

        Permission::create(['name' => 'planillas.create']);
        Permission::create(['name' => 'planillas.show']);
        Permission::create(['name' => 'planillas.edit']);
        Permission::create(['name' => 'planillas.delete']);


        $superAdmin = Role::findByName('superadministrador');
        $superAdmin->givePermissionTo(Permission::all());

        $userSuperAdmin = User::create([
            'document_id' => '1',
            'document_number' => '77205914',
            'name' => 'Super Admin',
            'last_name' => 'Dev',
            'telefono' => '918363389',
            'direccion' => '-',
            'email' => 'superadmin@planverde.com',
            'password' => bcrypt('superadmin'),
            'status' => 1
        ]);

        $userSuperAdmin->assignRole('superadministrador');

        //Administrador

        $userAdministrador = User::create([
            'document_id' => '1',
            'document_number' => '77205915',
            'name' => 'Prueba',
            'last_name' => 'Dev',
            'telefono' => '918363389',
            'direccion' => '-',
            'email' => 'administrador@planverde.com',
            'password' => bcrypt('administrador'),
            'status' => 1
        ]);

        $cliente = Role::findByName('administrador');
        $cliente->givePermissionTo([
            'usuarios.show',
            'usuarios.edit',
            'usuarios.create',
            'usuarios.delete',
            'usuarios.activate',
            'documentos.show',
            'documentos.edit',
            'documentos.create',
            'documentos.delete',
            'documentos.activate',
            'configuracion.show',
            'configuracion.edit',
            'encuestas.create',
            'encuestas.show',
            'encuestas.edit',
            'encuestas.delete',
            'formatos.create',
            'formatos.show',
            'formatos.edit',
            'formatos.delete'
        ]);
        $userAdministrador->assignRole('administrador');

        //Cliente

        $empresa = Empresas::create([
            'nombre' => 'Empresa prueba',
            'document_id' => 2,
            'document_number' => 10222222222,
            'email' => 'empresa-prueba@planverde.com',
            'telefono' => '999999999',
            'direccion' => '-----'
        ]);

        $roleCliente = User::create([
            'document_id' => '1',
            'document_number' => '22222222',
            'name' => 'cliente',
            'last_name' => 'Dev',
            'telefono' => '999999999',
            'direccion' => '-----',
            'email' => 'cliente@planverde.com',
            'password' => bcrypt('cliente'),
            'empresa_id' => $empresa->id,
            'status' => 1
        ]);

        $empresa->user_id = $roleCliente->id;
        $empresa->save();

        $plan = Planes::where('id',1)->first();
        $tipo_pago = 'anual';
        $fechaInicio = Carbon::now()->toDateString();;
        $fechaFin = ($tipo_pago == 'anual') ? Carbon::now()->addYear()->toDateString() : Carbon::now()->addMonth()->toDateString();
        Pagos::create(
            [
                'empresa_id' => $empresa->id,
                'user_id' => $roleCliente->id,
                'plan_id' => $plan->id,
                'tipo_pago' => $tipo_pago,
                'plan_nombre' => $plan->nombre,
                'plan_descripcion' => $plan->descripcion,
                'monto' => ($tipo_pago == 'anual') ? $plan->precio_anual : $plan->precio_mensual,
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'fecha_pago' => Carbon::now(),
                'status' => 1
            ]
        );


        $cliente = Role::findByName('cliente');
        $cliente->givePermissionTo([
            'usuarios.show',
            'usuarios.edit',
            'documentos.show',
            'documentos.edit',
            'documentos.create',
            'documentos.delete',
            'documentos.activate',
            'notificaciones.show',
            'notificaciones.edit',
            'plantillas.create',
            'plantillas.show',
            'plantillas.edit',
            'plantillas.delete',
            'incidencias.show',
            'incidencias.create',
            'incidencias.edit',
            'incidencias.delete',
            'pagos.create',
            'pagos.show',
            'pagos.edit',
            'encuestas.show',
            'encuestas.edit',
            'configuracion.show',
            'configuracion.edit',
            'formatos.show',
            'formatos.edit',
            'foro.show',
            'foro.create',
            'foro.edit',
            'foro.delete',
            'actas.show',
            'actas.create',
            'actas.edit',
            'actas.delete',
            'capacitaciones.show',
            'capacitaciones.create',
            'capacitaciones.edit',
            'capacitaciones.delete',
            'contratos.show',
            'contratos.create',
            'contratos.edit',
            'contratos.delete',
            'historial.show',
            'historial.create',
            'historial.edit',
            'historial.delete',
            'planillas.show',
            'planillas.create',
            'planillas.edit',
            'planillas.delete',
        ]);
        $roleCliente->assignRole('cliente');

        // MARKETING

        $roleMarketing = User::create([
            'document_id' => '1',
            'document_number' => '22222222',
            'name' => 'marketing',
            'last_name' => 'Dev',
            'telefono' => '999999999',
            'direccion' => '-----',
            'email' => 'marketing@planverde.com',
            'password' => bcrypt('marketing'),
            'status' => 1
        ]);

        $marketing = Role::findByName('marketing');
        $marketing->givePermissionTo([
            'usuarios.show',
            'usuarios.edit',
            'documentos.show',
            'documentos.edit',
            'documentos.create',
            'documentos.delete',
            'documentos.activate',
            'notificaciones.show',
            'notificaciones.edit',
            'plantillas.create',
            'plantillas.show',
            'plantillas.edit',
            'plantillas.delete',
            'incidencias.show',
            'incidencias.create',
            'incidencias.edit',
            'incidencias.delete',
            'pagos.create',
            'pagos.show',
            'pagos.edit',
            'encuestas.show',
            'encuestas.edit',
            'configuracion.show',
            'configuracion.edit',
            'formatos.show',
            'formatos.edit',
            'cotizaciones.show',
            'cotizaciones.create',
            'cotizaciones.edit',
            'cotizaciones.delete',
            'mensajes.show',
            'mensajes.create',
            'mensajes.edit',
            'mensajes.delete',
            'foro.show',
            'foro.create',
            'foro.edit',
            'foro.delete',
            'contactos.show',
            'contactos.create',
            'contactos.edit',
            'contactos.delete',
            'archivos.show',
            'archivos.create',
            'archivos.edit',
            'archivos.delete',

        ]);
        $roleMarketing->assignRole('marketing');

          // SOPORTE

          $roleSoporte = User::create([
            'document_id' => '1',
            'document_number' => '22222222',
            'name' => 'soporte',
            'last_name' => 'Dev',
            'telefono' => '999999999',
            'direccion' => '-----',
            'email' => 'soporte@planverde.com',
            'password' => bcrypt('soporte'),
            'status' => 1
        ]);

        $soporte = Role::findByName('soporte');
        $soporte->givePermissionTo([
            'usuarios.show',
            'usuarios.edit',
            'documentos.show',
            'documentos.edit',
            'documentos.create',
            'documentos.delete',
            'documentos.activate',
            'notificaciones.show',
            'notificaciones.edit',
            'plantillas.create',
            'plantillas.show',
            'plantillas.edit',
            'plantillas.delete',
            'incidencias.show',
            'incidencias.create',
            'incidencias.edit',
            'incidencias.delete',
            'pagos.create',
            'pagos.show',
            'pagos.edit',
            'encuestas.show',
            'encuestas.edit',
            'configuracion.show',
            'configuracion.edit',
            'formatos.show',
            'formatos.edit',
            'preguntasFaqs.create',
            'preguntasFaqs.show',
            'preguntasFaqs.edit',
            'preguntasFaqs.delete',
            'tickets.create',
            'tickets.show',
            'tickets.edit',
            'tickets.delete',
            'documentosSoporte.create',
            'documentosSoporte.show',
            'documentosSoporte.edit',
            'documentosSoporte.delete',
        ]);
        $roleSoporte->assignRole('soporte');





    }
}
