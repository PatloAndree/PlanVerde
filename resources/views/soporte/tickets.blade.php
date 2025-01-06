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
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">{{ $titulo }}</h5>
            <button class="btn btn-primary" id="new-survey-btn" data-bs-toggle="modal" data-bs-target="#ticketsModal">+
                Nuevo ticket</button>
        </div>

        <div class="card-body">
            <table class="table" id="tablaPreguntas">
                <thead class="border-top">
                    <tr>
                        <th>Titulo</th>
                        <th>Descrioción</th>
                        <th>Fecha Creación</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="modal fade" id="ticketsModal" tabindex="-1" aria-labelledby="encuestaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="encuestaModalLabel" style="text-transform: uppercase">Ticket</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="preguntasForm" novalidate  enctype="multipart/form-data">
                            <input type="hidden" id="ticketId" name="ticketId">

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="pregunta">Titulo :</label>
                                    <input type="text" name="titulo" id="titulo" class="form-control" value=""
                                        required="required" pattern="" title="">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="pregunta">Descripción :</label>
                                    <textarea name="descripcion" id="descripcion" class="form-control" required></textarea>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="pregunta">Adjuntar imagenes :</label>
                                    <input type="file" class="form-control" id="adjuntos" name="adjuntos[]"
                                        accept="image/*" multiple>
                                </div>
                            </div>
                            <div id="vista-previa" style="display: none;">
                                <img id="imagen-previa" src="" alt="Vista previa"
                                    style="max-width: 100%; max-height: 200px; margin-top: 10px;" />
                            </div>

                            <hr>

                            <div class="row mb-4" id="cols-questions">
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-end" id="divSaveEncuesta">
                                    <button type="submit" class="btn btn-primary mt-4" id="savePregunta">Guardar</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
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

        const formGuardarPregunta = document.getElementById('preguntasForm');
        let modalPreguntas = document.getElementById('ticketsModal');
        let table;
        let fv;

        document.addEventListener('DOMContentLoaded', () => {

            table = new DataTable('#tablaPreguntas', {
                // Configuración de DataTable
                ajax: {
                    url: "{{ role_route('tickets.list') }}",
                    dataSrc: function(json) {
                        if (!json.data) {
                            json.data = []; // Si no hay data, asegúrate de devolver un array vacío
                        }
                        return json.data;
                    }
                },
                dom: '<"card-header d-flex border-top rounded-0 flex-wrap py-0 flex-column flex-md-row align-items-start"<"me-5 ms-n4 pe-5 mb-n6 mb-md-0"f><"d-flex justify-content-start justify-content-md-end align-items-baseline"<"dt-action-buttons d-flex flex-column align-items-start align-items-sm-center justify-content-sm-center pt-0 gap-sm-4 gap-sm-0 flex-sm-row"lB>>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.1.7/i18n/es-ES.json'
                },
                columns: [{
                        data: 'titulo'
                    },

                    {
                        data: 'descripcion',
                        render: function(data) {
                            if (data) {
                                const words = data.split(/\s+/); // Divide el texto por espacios
                                if (words.length > 5) {
                                    return words.slice(0, 10).join(' ') +
                                        '...'; // Toma las primeras 50 palabras y añade "..."
                                }
                                return data; // Si tiene menos de 50 palabras, retorna el texto completo
                            }
                            return ''; // Si no hay respuesta, retorna vacío
                        }
                    },
                    {
                        data: 'fecha_inicio',

                    }, {
                        data: 'status',
                        render: function(data) {
                            // Cambia el texto del badge según el estado
                            switch (data) {
                                case 1:
                                    return `<span class="badge bg-label-success" text-capitalized>Activo</span>`;
                                case 2:
                                    return `<span class="badge bg-label-danger" text-capitalized>Inactivo</span>`;
                                case 0:
                                    return ''; // Omite "Eliminado"
                            }
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                    <button class="btn btn-sm btn-text-warning rounded-pill btn-icon" onclick="editar(${row.id})" title="Editar">
                                        <i class="ti ti-pencil ti-md"></i>
                                    </button>
                                        <button class="btn btn-sm btn-text-danger rounded-pill btn-icon" onclick="eliminar(${row.id})" title="borrar">
                                        <i class="ti ti-trash ti-md"></i>
                                    </button>
                                `;
                        }
                    }
                ],
                buttons: [],
                processing: true,
                error: function(xhr, error, thrown) {
                    console.error('Error en la carga de datos:', error, thrown);
                }
            });

        });

        fv = FormValidation.formValidation(
            formGuardarPregunta, {
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

        $('#ticketsModal').on('hidden.bs.modal', function() {
            document.getElementById('ticketId').value = 0;
            document.getElementById('preguntasForm').reset();
            fv.resetForm();
            const vistaPrevia = document.getElementById('vista-previa');
            const imagenPrevia = document.getElementById('imagen-previa');
            imagenPrevia.src = '';
            vistaPrevia.style.display = 'none';
        });

        formGuardarPregunta.addEventListener('submit', function(e) {
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
                    const formData = new FormData(formGuardarPregunta);
                    fetch("{{ role_route('tickets.save') }}", {
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
                            $("#ticketsModal").modal('hide');
                            $('#contenido-view').waitMe("hide");
                            Swal.fire({
                                toast: true,
                                position: "bottom-end",
                                showConfirmButton: false,
                                icon: "success",
                                timer: 3000,
                                title: 'Exito !'
                            });
                            table.ajax.reload();
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

                }else{
                    $('#contenido-view').waitMe("hide");
                }
            });
        });

        function editar(id) {
            // Busca el registro específico
            let url = `{{ role_route('tickets.edit', ':id') }}`;
            url = url.replace(':id', id);

            fetch(url)
                .then(response => response.json())
                .then(result => {
                    const data = result.data;

                    if (!data) {
                        console.error('No se encontró la encuesta.');
                        return;
                    }

                    // Carga valores básicos
                    document.getElementById('ticketId').value = data.id;
                    document.getElementById('titulo').value = data.titulo;
                    document.getElementById('descripcion').value = data.descripcion;
                    document.getElementById('fecha_inicio').value = data.fecha_inicio;

                    // Cargar la vista previa de la imagen si existe
                    const vistaPrevia = document.getElementById('vista-previa');
                    const imagenPrevia = document.getElementById('imagen-previa');

                    if (data.adjuntos) {
                        imagenPrevia.src = data.adjuntos;
                        vistaPrevia.style.display = 'block';
                    } else {
                        imagenPrevia.src = '';
                        vistaPrevia.style.display = 'none';
                    }

                    // Muestra el modal
                    $("#ticketsModal").modal('show');
                })
                .catch(error => console('Error al cargar los datos:'));
        }

        function eliminar(id) {
            // Mostrar la confirmación con SweetAlert
            Swal.fire({
                title: "¿Estás seguro?",
                text: "No podrás revertir esto.",
                icon: "warning",
                showCancelButton: false,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, eliminarlo",

                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Construye la URL para la eliminación
                    let url = `{{ role_route('tickets.delete', ':id') }}`;
                    url = url.replace(':id', id);

                    // Enviar la solicitud DELETE al backend
                    fetch(url, {
                            method: 'POST', // Usa POST si DELETE no es compatible
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Incluye el token CSRF
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Error al eliminar el registro.');
                            }
                            return response.json();
                        })
                        .then(result => {
                            if (result.success) {
                                // Notifica al usuario con SweetAlert
                                Swal.fire({
                                    toast: true,
                                    position: "bottom-end",
                                    showConfirmButton: false,
                                    icon: "success",
                                    timer: 3000,
                                    title: "Eliminado correctamente"
                                });
                                table.ajax.reload();

                            } else {
                                // Muestra un error si el backend no confirma la eliminación
                                Swal.fire({
                                    toast: true,
                                    position: "bottom-end",
                                    showConfirmButton: false,
                                    icon: "error",
                                    timer: 3000,
                                    title: 'Ocurrió un problema.'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error al eliminar:', error);
                            Swal.fire({
                                toast: true,
                                position: "bottom-end",
                                showConfirmButton: false,
                                icon: "error",
                                timer: 3000,
                                title: 'Ocurrió un problema.'
                            });
                        });
                }
            });
        }
    </script>
@endsection
