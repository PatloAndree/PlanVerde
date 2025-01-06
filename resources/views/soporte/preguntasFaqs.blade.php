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
    </style>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">{{ $titulo }}</h5>
            <button class="btn btn-primary" id="new-survey-btn" data-bs-toggle="modal" data-bs-target="#preguntasModal">+
                Nueva pregunta</button>
        </div>

        <div class="card-body">
            <table class="table" id="tablaPreguntas">
                <thead class="border-top">
                    <tr>
                        <th>Pregunta</th>
                        <th>Respuesta</th>
                        <th>Fecha Creación</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="modal fade" id="preguntasModal" tabindex="-1" aria-labelledby="encuestaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="encuestaModalLabel" style="text-transform: uppercase">Preguntas
                            Frecuentes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="preguntasForm" novalidate>
                            <input type="hidden" id="preguntaId" name="preguntaId">

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="pregunta">Pregunta :</label>
                                    <input type="text" name="pregunta" id="pregunta" class="form-control" value=""
                                        required="required" pattern="" title="">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="pregunta">Respuesta :</label>
                                    <textarea name="respuesta" id="respuesta" class="form-control"></textarea>
                                </div>
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
    <script src="{{ asset('js/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    <script src="{{ asset('js/popular.js') }}"></script>
    <script src="{{ asset('js/bootstrap5.js') }}"></script>
    <script src="{{ asset('js/auto-focus.js') }}"></script>
    <script src="https://formvalidation.io//vendors/@form-validation/umd/locales/es_ES.min.js"></script>
    <script src="{{ asset('js/sweetalert2.js') }}"></script>
    <script src="{{ asset('js/tagify.js') }}"></script>
    <script src="{{ asset('js/waitMe.js') }}"></script>
@endsection

@section('implemetenciones')
    <script>
        const formGuardarPregunta = document.getElementById('preguntasForm');
        let modalPreguntas = document.getElementById('preguntasModal');
        let fv;
        let table;

        document.addEventListener('DOMContentLoaded', () => {

            table = new DataTable('#tablaPreguntas', {
                // Configuración de DataTable
                ajax: {
                    url: "{{ role_route('preguntasFaqs.list') }}",
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
                        data: 'pregunta'
                    },

                    {
                        data: 'respuesta',
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
                        data: 'created_at',
                        render: function(data) {
                            // Extrae solo la fecha (YYYY-MM-DD) del valor completo de la fecha
                            if (data) {
                                return data.split('T')[0]; // Divide en "T" y toma la primera parte
                            }
                            return ''; // Si no hay fecha, retorna vacío
                        }
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

        formGuardarPregunta.addEventListener('submit', function(e) {
            e.preventDefault();
            $("#contenido-view").waitMe({
                effect: "win8_linear",
                bg: "rgba(255,255,255,0.9)",
                color: "#000",
                textPos: "vertical",
                fontSize: "250px",
            });
            const formData = new FormData(formGuardarPregunta);
            fetch("{{ role_route('preguntasFaqs.save') }}", {
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
                    $("#preguntasModal").modal('hide');
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
        });

        $('#encuestaModal').on('hidden.bs.modal', function() {
            document.getElementById('encuestaForm').reset();
            document.getElementById('id').value = 0;
            document.getElementById('cols-questions').innerHTML = '';
        });

        function editar(id) {
            // Busca el registro específico
            let url = `{{ role_route('preguntasFaqs.edit', ':id') }}`;
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
                    document.getElementById('preguntaId').value = data.id;
                    document.getElementById('pregunta').value = data.pregunta;
                    document.getElementById('respuesta').value = data.respuesta;

                    // Muestra el modal
                    $("#preguntasModal").modal('show');
                })
                .catch(error => console.error('Error al cargar los datos:', error));
        }

        $('#preguntasModal').on('hidden.bs.modal', function() {
            document.getElementById('preguntaId').value = 0;
            document.getElementById('preguntasForm').reset();
            fv.resetForm();
        });

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
                    let url = `{{ role_route('preguntasFaqs.delete', ':id') }}`;
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
