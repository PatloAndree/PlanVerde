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
        </div>

        <div class="card-body">
            <table class="table" id="tablaPreguntas">
                <thead class="border-top">
                    <tr>
                        <th>Titulo</th>
                        <th>Descrioción</th>
                        <th>Fecha Respuesta</th>
                        <th>Ver</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="modal fade" id="foroModal" tabindex="-1" aria-labelledby="encuestaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="encuestaModalLabel" style="text-transform: uppercase">Foro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="foroForm" novalidate>
                            <input type="hidden" id="foroId" name="foroId">

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h5 name="titulo" id="titulo" class="text-secondary fw-bold"> </h5>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <span name="descripcion" id="descripcion" class="text-secondary "></span>
                                </div>
                            </div>

                            <hr>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="pregunta">Respuesta :</label>
                                    <textarea name="respuesta" id="respuesta" class="form-control" required></textarea>
                                </div>
                            </div>

                            <h6>Respuestas:</h6>
                            <div id="respuestasContainer"></div>

                            <div class="row mb-4" id="cols-questions">
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary mt-4" id="saveForo">Guardar</button>
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
        const formGuardarForo = document.getElementById('foroForm');
        let modalPreguntas = document.getElementById('foroModal');
        let table;
        let fv;

        
        document.addEventListener('DOMContentLoaded', () => {

            table = new DataTable('#tablaPreguntas', {
                // Configuración de DataTable
                ajax: {
                    url: "{{ role_route('foro.list') }}",
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
                                        '...';
                                }
                                return data;
                            }
                            return '';
                        }
                    },
                    {
                        data: 'fecha_cierre',
                        render: function(data, type, row) {
                            return data && data.trim() !== '' ? data : 'Sin respuesta';
                        }

                    }, 
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-sm btn-text-dark text-center rounded-pill btn-icon" onclick="editar(${row.id})" title="Editar">
                                    <i class="ti ti-eye ti-md"></i>
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

        $('#foroModal').on('hidden.bs.modal', function() {
            document.getElementById('foroForm').reset();
            fv.resetForm();

        });

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
                            $("#foroModal").modal('hide');
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

                } else {
                    $('#contenido-view').waitMe("hide");
                }
            });
        });

        function editar5(id) {
            // Busca el registro específico
            let url = `{{ role_route('foro.edit', ':id') }}`;
            url = url.replace(':id', id);

            fetch(url)
                .then(response => response.json())
                .then(result => {
                    const data = result.data;

                    // Carga valores básicos del foro
                    document.getElementById('foroId').value = data.foro.id;
                    document.getElementById('titulo').textContent = data.foro.titulo;
                    document.getElementById('descripcion').textContent = data.foro.descripcion;

                    // Limpiar las respuestas anteriores
                    const respuestasContainer = document.getElementById('respuestasContainer');
                    respuestasContainer.innerHTML = '';

                    // Renderizar las respuestas asociadas
                    data.respuestas.forEach(respuesta => {
                        
                    const nombreCliente = respuesta.user ? respuesta.user.name : 'Anónimo';
                    const fecha = new Date(respuesta.created_at);
                    const fechaFormateada = `${fecha.getDate().toString().padStart(2, '0')}/${(fecha.getMonth() + 1).toString().padStart(2, '0')}/${fecha.getFullYear()} ${fecha.getHours().toString().padStart(2, '0')}:${fecha.getMinutes().toString().padStart(2, '0')}`;                        const respuestaHTML = `
                    <div class="respuesta-item">
                        <p><strong>${nombreCliente}:</strong> ${respuesta.mensaje}</p>
                        <small><strong>Fecha respuesta: </strong> ${fechaFormateada}</small>
                    </div>
                    <hr>`;
                        respuestasContainer.innerHTML += respuestaHTML;
                    });
                    // Mostrar el modal
                    $("#foroModal").modal('show');
                })
                .catch(error => console.error('Error al cargar los datos:', error));
        }

        function editar(id) {
            let url = `{{ role_route('foro.edit', ':id') }}`;
            url = url.replace(':id', id);
            window.location.href = url;
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
                    let url = `{{ role_route('foro.delete', ':id') }}`;
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
