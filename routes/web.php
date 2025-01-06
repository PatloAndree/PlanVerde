<?php

use App\Http\Controllers\Administrador\DocumentosController;
use App\Http\Controllers\Cliente\ConfiguracionController as ClienteConfiguracionController;
use App\Http\Controllers\ErrorsControllers;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Cliente\ActasController as ActasController;
use App\Http\Controllers\Cliente\CapacitacionesController as ClienteCapacitacionesController;
use App\Http\Controllers\Cliente\ContratosController as ContratosController;
use App\Http\Controllers\Cliente\HistorialController as ClienteHistorialController;
use App\Http\Controllers\Cliente\PlanillasController;
use App\Http\Controllers\Superadmin\EmpresaController;
use App\Http\Controllers\Superadmin\ActividadController;
use App\Http\Controllers\Superadmin\ConfiguracionController;
use App\Http\Controllers\Superadmin\PagosController;
use App\Http\Controllers\Superadmin\UsuarioController;
use App\Http\Controllers\Administrador\EncuestasController;
use App\Http\Controllers\Cliente\EncuestasController as ClienteEncuestasController;
use App\Http\Controllers\Cliente\PagosController as ClientePagosController;
use App\Http\Controllers\Administrador\FormatosController;
use App\Http\Controllers\Superadmin\ReportesController;
use App\Http\Controllers\Soporte\TicketsController;
use App\Http\Controllers\Soporte\FaqsController;
use App\Http\Controllers\Soporte\DocumentoSoporteController;
use App\Http\Controllers\Marketing\CotizacionesController;
use App\Http\Controllers\Marketing\ForoController;
use App\Http\Controllers\Marketing\MensajesController;
use App\Http\Controllers\Marketing\ArchivosController;
use App\Http\Controllers\Marketing\ContactosController;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', function () {
    return view('template.template');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/payment-blocked',[ErrorsControllers::class,'notpayment'])->name('payment.blocked');

Route::group(['prefix' => 'superadministrador', 'middleware' => ['auth', 'role:superadministrador']], function () {
    //Empresas
    Route::get('/empresas', [EmpresaController::class, 'show'])->middleware('permission:empresas.show')->name('empresas.show');
    Route::get('/empresas/list', [EmpresaController::class, 'list'])->middleware('permission:empresas.show')->name('empresas.list');
    Route::get('/empresas/data/{id}', [EmpresaController::class, 'data'])->middleware('permission:empresas.show')->name('empresas.data');
    Route::post('/empresas/delete/{id}', [EmpresaController::class, 'delete'])->middleware('permission:empresas.delete')->name('empresas.delete');
    Route::post('/empresas/activate}', [EmpresaController::class, 'activate'])->middleware('permission:empresas.activate')->name('empresas.activate');
    Route::post('/empresas/create', [EmpresaController::class, 'save'])->middleware('permission:empresas.create|empresas.edit')->name('empresas.save');
    //PAGOS
    Route::get('/pagos', [PagosController::class, 'show'])->middleware('permission:pagos.show')->name('superadministrador.pagos.show');
    Route::get('/pagos/list', [PagosController::class, 'list'])->middleware('permission:pagos.show')->name('superadministrador.pagos.list');
    Route::get('/pagos/data/{id}', [PagosController::class, 'data'])->middleware('permission:pagos.show')->name('superadministrador.pagos.data');
    Route::get('/pagos/dataEmpresa', [PagosController::class, 'dataEmpresa'])->middleware('permission:pagos.show')->name('superadministrador.pagos.dataEmpresa');
    Route::get('/pagos/dataUser/{id}', [PagosController::class, 'dataUser'])->middleware('permission:pagos.show')->name('superadministrador.pagos.dataUser');
    Route::post('/pagos/create', [PagosController::class, 'save'])->middleware('permission:pagos.create|pagos.edit')->name('superadministrador.pagos.save');

    //Actividades
    Route::get('/actividades', [ActividadController::class, 'show'])->middleware('permission:actividades.show')->name('actividades.show');
    Route::post('/actividades/create', [ActividadController::class, 'save'])->middleware('permission:actividades.create')->name('actividades.save');
    Route::post('/actividades/delete/{id}', [ActividadController::class, 'delete'])->middleware('permission:actividades.delete')->name('actividades.delete');
    Route::get('/actividades/listado', [ActividadController::class, 'listado'])->name('actividades.listado');
    Route::post('/actividades/imagenDelete/{id}', [ActividadController::class, 'destroy'])->name('actividadImagen.delete');

    //Usuarios
    Route::get('/usuarios', [UsuarioController::class, 'show'])->middleware('permission:usuarios.show')->name('superadministrador.usuarios.show');
    Route::get('/usuarios/list', [UsuarioController::class, 'list'])->middleware('permission:usuarios.show')->name('superadministrador.usuarios.list');
    Route::post('/usuarios/create', [UsuarioController::class, 'save'])->middleware('permission:usuarios.create')->name('superadministrador.usuarios.save');
    Route::post('/usuarios/profile', [UsuarioController::class, 'changePassword'])->middleware('permission:usuarios.edit')->name('superadministrador.usuarios.changePassword');
    Route::get('/usuarios/{id}', [UsuarioController::class, 'edit'])->middleware('permission:usuarios.edit')->name('superadministrador.usuarios.edit');
    Route::get('/profile', [ProfileController::class, 'show'])->name('superadministrador.profile.show');

    // REPORTES
    Route::get('/reportes', [ReportesController::class, 'show'])->middleware('permission:reportes.show')->name('reportes.show');
    Route::post('/reportes/dataIngresos', [ReportesController::class, 'dataIngresos'])->middleware('permission:reportes.show')->name('reportes.dataIngreso');

    // ENCUESTAS
    Route::get('/encuestas', [EncuestasController::class, 'show'])->middleware('permission:encuestas.show')->name('superadministrador.encuestas.show');
    Route::post('/encuestas/save', [EncuestasController::class, 'save'])->middleware('permission:encuestas.create')->name('superadministrador.encuestas.save');
    Route::get('/encuestas/list', [EncuestasController::class, 'list'])->middleware('permission:encuestas.show')->name('superadministrador.encuestas.list');
    Route::get('/encuestas/editar/{id}', [EncuestasController::class, 'editar'])->middleware('permission:encuestas.edit')->name('superadministrador.encuestas.edit');

    // CONFIGURACION
    Route::get('/configuracion', [ClienteConfiguracionController::class, 'show'])->name('cliente.configuracion.show');
    Route::post('/configuracion/save', [ClienteConfiguracionController::class, 'store'])->name('cliente.configuracion.store');

});
Route::group(['prefix' => 'administrador', 'middleware' => ['auth', 'role:administrador']], function(){
    //DOCUMENTOS
    Route::get('/documentos', [DocumentosController::class, 'show'])->middleware('permission:documentos.show')->name('documentos.show');
    Route::get('/documentos/list', [DocumentosController::class, 'list'])->middleware('permission:documentos.show')->name('documentos.list');
    Route::post('/documentos/create', [DocumentosController::class, 'save'])->middleware('permission:documentos.create|documentos.edit')->name('documentos.save');
    Route::get('/documentos/dataEmpresa/{id}', [DocumentosController::class, 'dataEmpresa'])->middleware('permission:documentos.show')->name('documentos.dataEmpresa');
    Route::get('/documentos/download/{id}', [DocumentosController::class, 'download'])->middleware('permission:documentos.show')->name('documentos.download');
    // USUARIOS
    Route::get('/usuarios', [UsuarioController::class, 'show'])->middleware('permission:usuarios.show')->name('administrador.usuarios.show');
    Route::get('/usuarios/list', [UsuarioController::class, 'list'])->middleware('permission:usuarios.show')->name('administrador.usuarios.list');
    Route::post('/usuarios/create', [UsuarioController::class, 'save'])->middleware('permission:usuarios.create')->name('administrador.usuarios.save');
    Route::post('/usuarios/profile', [UsuarioController::class, 'changePassword'])->middleware('permission:usuarios.edit')->name('administrador.usuarios.changePassword');
    Route::get('/usuarios/{id}', [UsuarioController::class, 'edit'])->middleware('permission:usuarios.edit')->name('administrador.usuarios.edit');
    Route::get('/profile', [ProfileController::class, 'show'])->name('administrador.profile.show');
    // CONFIGURACION
    Route::get('/configuracion', [ConfiguracionController::class, 'show'])->middleware('permission:configuracion.show')->name('administrador.configuracion.show');
    Route::post('/configuracion/save', [ConfiguracionController::class, 'store'])->middleware('permission:configuracion.show')->name('administrador.configuracion.store');
    // ENCUESTAS
    Route::get('/encuestas', [EncuestasController::class, 'show'])->middleware('permission:encuestas.show')->name('administrador.encuestas.show');
    Route::post('/encuestas/save', [EncuestasController::class, 'save'])->middleware('permission:encuestas.create')->name('administrador.encuestas.save');
    Route::get('/encuestas/list', [EncuestasController::class, 'list'])->middleware('permission:encuestas.show')->name('administrador.encuestas.list');
    Route::get('/encuestas/editar/{id}', [EncuestasController::class, 'editar'])->middleware('permission:encuestas.edit')->name('administrador.encuestas.edit');
    Route::post('/encuestas/delete/{id}', [EncuestasController::class, 'destroy'])->middleware('permission:encuestas.delete')->name('administrador.encuestas.delete');
    // FORMATOS
    Route::get('/formatos/', [FormatosController::class, 'show'])->middleware('permission:formatos.show')->name('administrador.formatos.show');
    Route::post('/formatos/save', [FormatosController::class, 'save'])->middleware('permission:formatos.create')->name('administrador.formatos.save');
    Route::get('/formatos/list', [FormatosController::class, 'list'])->middleware('permission:formatos.show')->name('administrador.formatos.list');
    Route::get('/formatos/editar/{id}', [FormatosController::class, 'editar'])->middleware('permission:formatos.edit')->name('administrador.formatos.edit');
    Route::post('/formatos/delete/{id}', [FormatosController::class, 'destroy'])->middleware('permission:formatos.delete')->name('administrador.formatos.delete');

});
Route::group(['prefix' => 'cliente', 'middleware' => ['auth', 'role:cliente', 'verify_company_payment']], function(){
    Route::get('/usuarios', [UsuarioController::class, 'show'])->middleware('permission:usuarios.show')->name('cliente.usuarios.show');
    Route::get('/usuarios/list', [UsuarioController::class, 'list'])->middleware('permission:usuarios.show')->name('cliente.usuarios.list');
    Route::post('/usuarios/create', [UsuarioController::class, 'save'])->middleware('permission:usuarios.create')->name('cliente.usuarios.save');
    Route::post('/usuarios/profile', [UsuarioController::class, 'changePassword'])->middleware('permission:usuarios.edit')->name('cliente.usuarios.changePassword');
    Route::get('/usuarios/{id}', [UsuarioController::class, 'edit'])->middleware('permission:usuarios.edit')->name('cliente.usuarios.edit');
    Route::get('/profile', [ProfileController::class, 'show'])->name('cliente.profile.show');
    Route::get('/configuracion', [ClienteConfiguracionController::class, 'show'])->name('cliente.configuracion.show');
    Route::post('/configuracion/save', [ClienteConfiguracionController::class, 'store'])->name('cliente.configuracion.store');

    // ENCUESTAS
    Route::get('/encuestas', [ClienteEncuestasController::class, 'show'])->middleware('permission:encuestas.show')->name('cliente.encuestas.show');
    Route::get('/encuestas/list', [ClienteEncuestasController::class, 'list'])->middleware('permission:encuestas.show')->name('cliente.encuestas.list');
    Route::post('/encuestas/save', [ClienteEncuestasController::class, 'save'])->middleware('permission:encuestas.edit')->name('cliente.encuestas.save');
    Route::get('/encuestas/editar/{encuestaId}/{encuestaClienteId}', [ClienteEncuestasController::class, 'editar'])->middleware('permission:encuestas.edit')->name('cliente.encuestas.edit');

    // PAGOS
    Route::get('/pagos', [ClientePagosController::class, 'show'])->middleware('permission:pagos.show')->name('cliente.pagos.show');
    Route::get('/pagos/list', [ClientePagosController::class, 'list'])->middleware('permission:pagos.show')->name('cliente.pagos.list');
    Route::get('/pagos/data/{id}', [ClientePagosController::class, 'data'])->middleware('permission:pagos.show')->name('cliente.pagos.data');
    Route::get('/pagos/dataEmpresa', [ClientePagosController::class, 'dataEmpresa'])->middleware('permission:pagos.show')->name('cliente.pagos.dataEmpresa');
    Route::get('/pagos/dataUser/{id}', [ClientePagosController::class, 'dataUser'])->middleware('permission:pagos.show')->name('cliente.pagos.dataUser');
    Route::post('/pagos/create', [ClientePagosController::class, 'save'])->middleware('permission:pagos.create|pagos.edit')->name('cliente.pagos.save');
    //FORO
    Route::get('/foros', [ForoController::class, 'showCliente'])->middleware('permission:foro.show')->name('cliente.foro.show');
    Route::get('/foros/list', [ForoController::class, 'list'])->middleware('permission:foro.show')->name('cliente.foro.list');
    Route::post('/foros/create', [ForoController::class, 'saveRespuesta'])->middleware('permission:foro.create')->name('cliente.foro.save');
    Route::get('/foros/editar/{id}', [ForoController::class, 'editarRespuesta'])->middleware('permission:foro.show')->name('cliente.foro.edit');
    Route::post('/foros/delete/{id}', [ForoController::class, 'delete'])->middleware('permission:foro.delete')->name('cliente.foro.delete');

    Route::post('/foros/destroy/{id}', [ForoController::class, 'destroy'])->middleware('permission:foro.edit')->name('cliente.foro_respuesta.edit');


    //Acliente.ctividades
    Route::get('/actividades', [ActividadController::class, 'show'])->middleware('permission:actividades.show')->name('cliente.actividades.show');
    Route::post('/actividades/create', [ActividadController::class, 'save'])->middleware('permission:actividades.create')->name('actividades.save');
    Route::post('/actividades/delete/{id}', [ActividadController::class, 'delete'])->middleware('permission:actividades.delete')->name('actividades.delete');
    Route::get('/actividades/listado', [ActividadController::class, 'listado'])->name('actividades.listado');
    Route::post('/actividades/imagenDelete/{id}', [ActividadController::class, 'destroy'])->name('actividadImagen.delete');

    // ACTAS
    Route::get('/actas', [ActasController::class, 'show'])->middleware('permission:actas.show')->name('cliente.actas.show');
    // CAPACITACIONES
    Route::get('/capacitaciones', [ClienteCapacitacionesController::class, 'show'])->middleware('permission:capacitaciones.show')->name('cliente.capacitaciones.show');
    // CONTRATOS
    Route::get('/Contratos', [ContratosController::class, 'show'])->middleware('permission:contratos.show')->name('cliente.contratos.show');
    // HISTORIAL
    Route::get('/historial', [ClienteHistorialController::class, 'show'])->middleware('permission:historial.show')->name('cliente.historial.show');
    // PLANTILLAS
    Route::get('/planillas', [PlanillasController::class, 'show'])->middleware('permission:planillas.show')->name('cliente.planillas.show');

});
Route::group(['prefix' => 'marketing', 'middleware' => ['auth', 'role:marketing']], function(){

    Route::get('/usuarios', [UsuarioController::class, 'show'])->middleware('permission:usuarios.show')->name('marketing.usuarios.show');
    Route::get('/usuarios/list', [UsuarioController::class, 'list'])->middleware('permission:usuarios.show')->name('marketing.usuarios.list');
    Route::post('/usuarios/create', [UsuarioController::class, 'save'])->middleware('permission:usuarios.create')->name('marketing.usuarios.save');
    Route::post('/usuarios/profile', [UsuarioController::class, 'changePassword'])->middleware('permission:usuarios.edit')->name('marketing.usuarios.changePassword');
    Route::get('/usuarios/{id}', [UsuarioController::class, 'edit'])->middleware('permission:usuarios.edit')->name('marketing.usuarios.edit');

    Route::get('/profile', [ProfileController::class, 'show'])->name('marketing.profile.show');

    Route::get('/cotizaciones', [CotizacionesController::class, 'show'])->middleware('permission:cotizaciones.show')->name('marketing.cotizaciones.show');

    Route::get('/foros', [ForoController::class, 'show'])->middleware('permission:foro.show')->name('marketing.foro.show');
    Route::get('/foros/list', [ForoController::class, 'list'])->middleware('permission:foro.show')->name('marketing.foro.list');
    Route::post('/foros/create', [ForoController::class, 'save'])->middleware('permission:foro.create')->name('marketing.foro.save');
    Route::get('/foros/editar/{id}', [ForoController::class, 'editar'])->middleware('permission:foro.edit')->name('marketing.foro.edit');
    Route::post('/foros/delete/{id}', [ForoController::class, 'delete'])->middleware('permission:foro.delete')->name('marketing.foro.delete');

    Route::get('/mensajes', [MensajesController::class, 'show'])->middleware('permission:mensajes.show')->name('marketing.mensajes.show');
    Route::get('/archivos', [ArchivosController::class, 'show'])->middleware('permission:archivos.show')->name('marketing.archivos.show');
    Route::get('/contactos', [ContactosController::class, 'show'])->middleware('permission:contactos.show')->name('marketing.contactos.show');


});
Route::group(['prefix' => 'soporte', 'middleware' => ['auth', 'role:soporte']], function(){

    Route::get('/usuarios', [UsuarioController::class, 'show'])->middleware('permission:usuarios.show')->name('soporte.usuarios.show');
    Route::get('/usuarios/list', [UsuarioController::class, 'list'])->middleware('permission:usuarios.show')->name('soporte.usuarios.list');
    Route::post('/usuarios/create', [UsuarioController::class, 'save'])->middleware('permission:usuarios.create')->name('soporte.usuarios.save');
    Route::post('/usuarios/profile', [UsuarioController::class, 'changePassword'])->middleware('permission:usuarios.edit')->name('soporte.usuarios.changePassword');
    Route::get('/usuarios/{id}', [UsuarioController::class, 'edit'])->middleware('permission:usuarios.edit')->name('soporte.usuarios.edit');
    Route::get('/profile', [ProfileController::class, 'show'])->name('soporte.profile.show');

    Route::get('/faqs', [FaqsController::class, 'show'])->name('soporte.preguntasFaqs.show');
    Route::get('/faqs/list', [FaqsController::class, 'list'])->middleware('permission:preguntasFaqs.show')->name('soporte.preguntasFaqs.list');
    Route::post('/faqs/create', [FaqsController::class, 'save'])->middleware('permission:preguntasFaqs.create')->name('soporte.preguntasFaqs.save');
    Route::get('/faqs/editar/{id}', [FaqsController::class, 'editar'])->middleware('permission:preguntasFaqs.edit')->name('soporte.preguntasFaqs.edit');
    Route::post('/faqs/delete/{id}', [FaqsController::class, 'delete'])->middleware('permission:preguntasFaqs.delete')->name('soporte.preguntasFaqs.delete');

    Route::get('/tickets', [TicketsController::class, 'show'])->name('soporte.tickets.show');
    Route::get('/tickets/list', [TicketsController::class, 'list'])->middleware('permission:preguntasFaqs.show')->name('soporte.tickets.list');
    Route::post('/tickets/create', [TicketsController::class, 'save'])->middleware('permission:preguntasFaqs.create')->name('soporte.tickets.save');
    Route::get('/tickets/editar/{id}', [TicketsController::class, 'editar'])->middleware('permission:preguntasFaqs.edit')->name('soporte.tickets.edit');
    Route::post('/tickets/delete/{id}', [TicketsController::class, 'delete'])->middleware('permission:preguntasFaqs.delete')->name('soporte.tickets.delete');

    Route::get('/documentos', [DocumentoSoporteController::class, 'show'])->name('soporte.documentosSoporte.show');
    Route::get('/documentos/list', [DocumentoSoporteController::class, 'list'])->middleware('permission:documentosSoporte.show')->name('soporte.documentosSoporte.list');
    Route::post('/documentos/create', [DocumentoSoporteController::class, 'save'])->middleware('permission:documentosSoporte.create|documentosSoporte.edit')->name('soporte.documentosSoporte.save');
    Route::get('/documentos/dataEmpresa/{id}', [DocumentoSoporteController::class, 'dataEmpresa'])->middleware('permission:documentosSoporte.show')->name('soporte.documentosSoporte.dataEmpresa');
    Route::post('/documentos/delete/{id}', [DocumentoSoporteController::class, 'delete'])->middleware('permission:documentosSoporte.delete')->name('soporte.documentosSoporte.delete');
    Route::get('/documentos/download/{id}', [DocumentoSoporteController::class, 'download'])->middleware('permission:documentosSoporte.show')->name('soporte.documentosSoporte.download');

});

//COMPARTIDAS

require __DIR__.'/auth.php';
