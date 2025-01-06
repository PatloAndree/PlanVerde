@extends('template.template')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('css/waitMe.css') }}" />
<style>
    .ql-editor {
    font-family: monospace; /* Fuente de estilo código */
    white-space: pre; /* Mantiene el formato del código */
}
</style>
@endsection
@section('content')
    <div class="card">
        <form id="configuracionesForm" novalidate>
            <div class="card-header header-elements">
                <h5 class="mb-0 me-2">Configuración</h5>
                <div class="card-header-elements ms-auto">
                    <button type="button" id="saveButton" class="btn btn-primary">Guardar</button>
                </div>
            </div>
            <div class="nav-align-top nav-tabs-shadow">
                <ul class="nav nav-tabs nav-fill" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-generales" aria-controls="navs-generales" aria-selected="true"><span
                                class="d-none d-sm-block"><i class="tf-icons ti ti-home ti-sm me-1_5"></i> Generales
                            </span><i class="ti ti-home ti-sm d-sm-none"></i></button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-implementaciones" aria-controls="navs-implementaciones" aria-selected="false"><span class="d-none d-sm-block"><i class="tf-icons ti ti-user ti-sm me-1_5"></i> Implementaciones </span><i class="ti ti-user ti-sm d-sm-none"></i></button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-notificaciones" aria-controls="navs-notificaciones" aria-selected="false"><span class="d-none d-sm-block"><i class="tf-icons ti ti-message-dots ti-sm me-1_5"></i> Notificaciónes </span><i class="ti ti-message-dots ti-sm d-sm-none"></i></button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="navs-generales" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="titulo" class="form-label">Nombre de la plataforma</label>
                                    <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ingresa el nombre de la plataforma" value="{{$empresa->nombre}}" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="ruc" class="form-label">RUC</label>
                                    <input type="text" class="form-control" id="ruc" name="ruc" placeholder="Ingresa el ruc" value="{{$empresa->documento}}" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingresa teléfono" value="{{$empresa->telefono}}" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="correo" class="form-label">Correo</label>
                                    <input type="text" class="form-control" id="correo" name="correo" placeholder="Ingresa correo electrónico" value="{{$empresa->correo}}" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="direccion" class="form-label">Dirección</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ingresa dirección" value="{{$empresa->direccion}}" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <label for="formFile" class="form-label">Logotipo</label>
                                <div class="d-flex align-items-center my-3">
                                    <!-- Imagen de vista previa -->
                                    <div class="me-3">
                                    <img id="preview-image" src="https://placeholder.pics/svg/300" alt="Imagen de previsualización" class="img-thumbnail" style="width: 100px; height: 100px;">
                                    </div>
                                    <!-- Input para subir archivo -->
                                    <div>
                                    <input class="form-control" type="file" id="formFile" accept="image/*" onchange="loadFile(event)">
                                    <small class="form-text text-muted">Selecciona una imagen en formato JPG O PNG.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <label for="formFile" class="form-label">Favicon</label>
                                <div class="d-flex align-items-center my-3">
                                    <!-- Imagen de vista previa -->
                                    <div class="me-3">
                                      <img id="preview-image" src="{{ asset('img').'/'.$empresa->favicon}}" alt="Imagen de previsualización" class="img-thumbnail" style="width: 100px; height: 100px;">
                                    </div>
                                    <!-- Input para subir archivo -->
                                    <div>
                                      <input class="form-control" type="file" id="formFile" accept="image/*" onchange="loadFile(event)">
                                      <small class="form-text text-muted">Selecciona una imagen en formato JPG O PNG.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-implementaciones" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="implementacion_googledrive" class="form-label text-black">Credencial para google drive</label>
                                    <textarea class="form-control" name="implementacion_googledrive" id="implementacion_googledrive" cols="30" rows="8">{{$empresa->implementacion_drive_config}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-notificaciones" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <h5>Notificación de vencimiento</h5>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="mb-3">
                                    <label for="vencimiento_ejecucion" class="form-label">Hora ejecución</label>
                                    <input type="text" class="form-control" id="vencimiento_ejecucion" value="{{$empresa->notificacion_vencimiento_hora_ejecucion}}" name="vencimiento_ejecucion" required>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="mb-3">
                                    <label for="vencimiento_dias_previos" class="form-label">Aviso x diás antes</label>
                                    <input type="number" min="0" max="10" class="form-control" id="vencimiento_dias_previos" value="{{$empresa->notificacion_vencimiento_dias_previos}}" name="vencimiento_dias_previos" required>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="mb-3">
                                    <label for="vencimiento_dias_posteriores" class="form-label">Aviso x diás despues</label>
                                    <input type="number" min="0" max="10" class="form-control" id="vencimiento_dias_posteriores" value="{{$empresa->notificacion_vencimiento_dias_posteriores}}" name="vencimiento_dias_posteriores" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="vencimiento_mensaje" class="form-label">Mensaje vencimiento</label>
                                    <textarea class="form-control" name="vencimiento_mensaje" id="vencimiento_mensaje" cols="30" rows="10">{{$empresa->notificacion_vencimiento_mensaje}}</textarea>
                                </div>
                            </div>
                        </div>
                        <hr class="my-6">
                        <div class="row">
                            <div class="col-12">
                                <h5>Notificación de actividades</h5>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="actividad_ejecucion" class="form-label">Hora ejecución</label>
                                    <input type="text" class="form-control" id="actividad_ejecucion" value="{{$empresa->notificacion_actividades_hora_ejecucion}}" name="actividad_ejecucion" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="actividad_dias_previos" class="form-label">Aviso x diás antes</label>
                                    <input type="number" min="0" max="10" class="form-control" id="actividad_dias_previos" value="{{$empresa->notificacion_actividades_dias_previos}}" name="actividad_dias_previos" required>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @endsection
    @section('content')
<script src="{{ asset('js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
<script src="{{ asset('js/waitMe.js') }}"></script>
<script src="https://formvalidation.io//vendors/@form-validation/umd/locales/es_ES.min.js"></script>

@endsection
@section('implemetenciones')
    <script>
        const updateButton = document.getElementById('saveButton');
        const fv = FormValidation.formValidation(
            document.getElementById('configuracionesForm'),
            {
                fields: {}, // No es necesario especificar campos individuales
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    declarative: new FormValidation.plugins.Declarative({
                        html5Input: true, // Usa atributos HTML5
                    }),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        eleInvalidClass: 'is-invalid',
                        eleValidClass: "",
                    }),
                },
            }
        );
  

        const loadFile = (event) => {
            const previewImage = document.getElementById('preview-image');
            previewImage.src = URL.createObjectURL(event.target.files[0]);
        };

        document.querySelectorAll('#vencimiento_ejecucion, #actividad_ejecucion').forEach(function(element) {
            element.flatpickr({
                enableTime: true,
                noCalendar: true,
                time_24hr: true
            });
        });

        updateButton.addEventListener('click', async function() {
            const status = await fv.validate();
            $("#contenido-view").waitMe({
                effect: "win8_linear",
                bg: "rgba(255,255,255,0.9)",
                color: "#000",
                textPos: "vertical",
                fontSize: "250px",
            });
            if(status === 'Valid'){
                const formData = new FormData(document.querySelector('#configuracionesForm'));
                try {
                    const response = await fetch('{{ role_route("configuracion.store") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }
                    });

                    const responseData = await response.json();

                    if(responseData.success){
                        Swal.fire({
                            toast:true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            icon: "success",
                            timer: 3000,
                            title: responseData.message
                        });
                        $('#contenido-view').waitMe("hide");
                    }else{
                        Swal.fire({
                            toast:true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            icon: "error",
                            timer: 3000,
                            title: responseData.message
                        });
                        $('#contenido-view').waitMe("hide");
                    }

                } catch (error) {
                    console.error('Error al guardar los datos:', error);
                    Swal.fire({
                        toast:true,
                        position: "bottom-end",
                        showConfirmButton: false,
                        icon: "error",
                        timer: 3000,
                        title: 'Ocurrio un problema.'
                    });
                    $('#contenido-view').waitMe("hide");
                }
            }else{
                $('#contenido-view').waitMe("hide");
            }
        });

    </script>
@endsection
