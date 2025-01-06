@extends('template.template')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/waitMe.css') }}" />
    <style>
        .btn-remove {
            background-color: #ff5c5c;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-remove:hover {
            background-color: #ff2c2c;
        }

        .btn-add {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-add:hover {
            background-color: #0056b3;
        }

        #vista-previa {
            text-align: center;
            margin-top: 10px;
        }

        #imagen-previa {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            background-color: #f9f9f9;
        }
    </style>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <form id="foroForm" novalidate>
                <input type="hidden" id="foroId" name="foroId" value="{{ $foro->id }}">

                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 name="titulo" id="titulo" class="text-secondary fw-bold"> {{ $foro->titulo }}</h5>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12 ">
                        <span name="descripcion" id="descripcion" class="text-secondary ">
                            {{ $foro->descripcion }}
                        </span>
                    </div>
                </div>
                <hr>
                <div class="row mb-4">
                    <div class="col-md-12 text-start">
                        <button type="button" class="btn btn-primary" id="btnMostrarFormulario"
                            onclick="toggleFormulario()">Añadir Respuesta</button>
                    </div>
                </div>

                <div id="formularioRespuesta" style="display: none;">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label for="pregunta">Nueva Respuesta:</label>
                            <textarea name="respuesta" id="respuesta" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary mt-4" id="saveForo">Guardar</button>
                    </div>
                </div>
                </div>

                <h6>Respuestas Anteriores:</h6>
                <div id="respuestasContainer">
                    @foreach ($respuestas as $respuesta)
                        <div class="respuesta-item mb-3 d-flex align-items-center" id="respuesta-{{ $respuesta->id }}">
                            <div class="flex-grow-1">
                                <p><strong>{{ $respuesta->user->name ?? 'Anónimo' }}</strong></p>
                                @if (auth()->id() === $respuesta->user_id)
                                    <textarea id="editarRespuesta_{{ $respuesta->id }}" class="form-control mb-2">{{ $respuesta->mensaje }}</textarea>
                                @else
                                    <p>{{ $respuesta->mensaje }}</p>
                                @endif
                                <small class="text-muted">
                                    <strong>Fecha respuesta: </strong>
                                    {{ \Carbon\Carbon::parse($respuesta->created_at)->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            @if (auth()->id() === $respuesta->user_id)
                                <div class="ms-3">
                                    <button type="button" class="btn btn-sm"
                                        onclick="editarRespuesta({{ $respuesta->id }})"><i
                                            class="ti ti-device-floppy ti-md text-dark"></i></button>
                                    <button type="button" class="btn btn-sm"
                                        onclick="eliminarRespuesta({{ $respuesta->id }})"><i
                                            class="ti ti-trash ti-md text-danger"></i></button>
                                </div>
                            @endif
                        </div>
                        <hr>
                    @endforeach
                </div>

                <div class="row mb-4" id="cols-questions">
                </div>

              

            </form>
        </div>
    </div>


    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
    <script src="https://formvalidation.io/vendors/@form-validation/umd/locales/es_ES.min.js"></script>
    <script src="{{ asset('js/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    <script src="{{ asset('js/popular.js') }}"></script>
    <script src="{{ asset('js/bootstrap5.js') }}"></script>
    <script src="{{ asset('js/auto-focus.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.js') }}"></script>
    <script src="{{ asset('js/waitMe.js') }}"></script>
@endsection

@section('implemetenciones')
    <script>
        const formGuardarForo = document.getElementById('foroForm');
        let modalPreguntas = document.getElementById('foroModal');
        let fv;

        function toggleFormulario() {
            const formulario = document.getElementById('formularioRespuesta');
            const boton = document.getElementById('btnMostrarFormulario');
            const campoRespuesta = document.getElementById('respuesta');

            if (formulario.style.display === 'none' || formulario.style.display === '') {
                // Mostrar el formulario y cambiar texto del botón
                formulario.style.display = 'block';
                boton.textContent = 'Ocultar Respuesta';
                campoRespuesta.value="";
            } else {
                // Ocultar el formulario y restaurar texto del botón
                formulario.style.display = 'none';
                boton.textContent = 'Añadir Respuesta';
            }
        }


        fv = FormValidation.formValidation(
            formGuardarForo, {
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

        formGuardarForo.addEventListener('submit', function(e) {
            e.preventDefault();
            $("#contenido-view").waitMe({
                effect: "win8_linear",
                bg: "rgba(255,255,255,0.9)",
                color: "#000",
                textPos: "vertical",
                fontSize: "250px",
            });
            fv.validate().then(function(status) {
                if (status === 'Valid') {
                    const formData = new FormData(formGuardarForo);
                    fetch("{{ role_route('foro.save') }}", {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(errorData => {
                                    throw errorData;
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Datos guardados exitosamente:', data);
                            window.location.href = "{{ role_route('foro.show') }}";
                            $('#contenido-view').waitMe("hide");
                            Swal.fire({
                                toast: true,
                                position: "bottom-end",
                                showConfirmButton: false,
                                icon: "success",
                                timer: 3000,
                                title: 'Exito !'
                            });
                        })
                        .catch(error => {
                            console.error('Error al guardar los datos:', error);
                            $('#contenido-view').waitMe("hide");
                            if (error.message) {
                                // alert(error.message);
                                Swal.fire({
                                    toast: true,
                                    position: "bottom-end",
                                    showConfirmButton: false,
                                    icon: "error",
                                    timer: 3000,
                                    title: 'Hubo un problema !'
                                });
                                $('#contenido-view').waitMe("hide");

                            } else {
                                Swal.fire({
                                    toast: true,
                                    position: "bottom-end",
                                    showConfirmButton: false,
                                    icon: "error",
                                    timer: 3000,
                                    title: 'Hubo un problema !'
                                });
                                $('#contenido-view').waitMe("hide");

                            }
                            if (error.errors) {
                                Swal.fire({
                                    toast: true,
                                    position: "bottom-end",
                                    showConfirmButton: false,
                                    icon: "error",
                                    timer: 3000,
                                    title: 'Hubo un problema al editar los datos.'
                                });
                                $('#contenido-view').waitMe("hide");

                            }
                        });

                } else {
                    $('#contenido-view').waitMe("hide");
                }
            });
        });


        function editarRespuesta(respuestaId) {
            const formEditarRespuesta = document.createElement('form'); // Crear un formulario temporal
            const mensaje = document.getElementById(`editarRespuesta_${respuestaId}`).value;

            if (mensaje.trim() === '') {
                Swal.fire({
                    toast: true,
                    position: "bottom-end",
                    showConfirmButton: false,
                    icon: "error",
                    timer: 3000,
                    title: 'El mensaje no puede estar vacío.'
                });
                return;
            }

            // Mostrar loader
            $("#contenido-view").waitMe({
                effect: "win8_linear",
                bg: "rgba(255,255,255,0.9)",
                color: "#000",
                textPos: "vertical",
                fontSize: "250px",
            });

            // Crear el FormData manualmente
            const formData = new FormData();
            formData.append('respuestaId', respuestaId);
            formData.append('respuesta', mensaje);
            formData.append('foroId', document.getElementById('foroId').value);

            fetch("{{ role_route('foro.save') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw errorData;
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('¡Exito editada exitosamente:', data);
                    Swal.fire({
                        toast: true,
                        position: "bottom-end",
                        showConfirmButton: false,
                        icon: "success",
                        timer: 3000,
                        title: '¡Exito!'
                    });
                    $('#contenido-view').waitMe("hide");

                    // Actualizar la interfaz, opcionalmente
                    document.getElementById(`editarRespuesta_${respuestaId}`).value = data.data.mensaje;
                })
                .catch(error => {
                    console.error('Error al editar la respuesta:', error);
                    $('#contenido-view').waitMe("hide");
                    Swal.fire({
                        toast: true,
                        position: "bottom-end",
                        showConfirmButton: false,
                        icon: "error",
                        timer: 3000,
                        title: 'Hubo un problema.'
                    });
                });
        }

        function eliminarRespuesta(respuestaId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#contenido-view").waitMe({
                        effect: "win8_linear",
                        bg: "rgba(255,255,255,0.9)",
                        color: "#000",
                    });

                    let url = `{{ role_route('foro_respuesta.edit', ':id') }}`;
                    url = url.replace(':id', respuestaId);

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                            },
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(errorData => {
                                    throw errorData;
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Respuesta eliminada:', data);
                            document.getElementById(`respuesta-${respuestaId}`).remove();
                            Swal.fire({
                                toast: true,
                                position: "bottom-end",
                                showConfirmButton: false,
                                icon: "success",
                                timer: 3000,
                                title: '¡Respuesta eliminada con éxito!',
                            });
                            $('#contenido-view').waitMe("hide");
                        })
                        .catch(error => {
                            console.error('Error al eliminar la respuesta:', error);
                            Swal.fire({
                                toast: true,
                                position: "bottom-end",
                                showConfirmButton: false,
                                icon: "error",
                                timer: 3000,
                                title: 'Hubo un problema al eliminar.',
                            });
                            $('#contenido-view').waitMe("hide");
                        });
                }
            });
        }

    </script>
@endsection
