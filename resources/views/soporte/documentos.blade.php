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
            <button class="btn btn-primary" id="new-survey-btn" data-bs-toggle="modal" data-bs-target="#encuestaModal">+
                Nuevo documento</button>
        </div>

        <div class="card-body">
        <table class="table" id="tableDocumentos">
                <thead class="border-top">
                <tr>
                    <th>Titulo</th>
                    <th>Subido por</th>
                    <th>Fecha subida</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Acciónes</th>
                </tr>
                </thead>
            </table>
        </div>

        <div class="modal fade" id="encuestaModal" tabindex="-1" aria-labelledby="encuestaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="encuestaModalLabel" style="text-transform: uppercase">Documentos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="documentoForm" novalidate>
                        <div class="modal-body">
                            <input type="hidden" name="documento_id" id="documento_id" value="">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="text-light fw-medium">Datos del Documento</h5>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre del Documento</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="mb-3">
                                        <label for="tipo" class="form-label">Tipo</label>
                                        <select class="form-select" name="tipo" id="tipo" required>
                                            <option value="">Seleccionar</option>
                                            <option value="1">Documento General</option>
                                            <option value="2">Documento con Vencimiento</option>
                                            <option value="3" class="d-none">Documento de Incidencia</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 d-none">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Estado</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="1">Públicado</option>
                                            <option value="2">No públicado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="archivo" class="form-label">Subir Archivo</label>
                                        <input type="file" class="form-control" id="archivo" name="archivo">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-end" id="divSaveEncuesta">
                                    <button type="submit" class="btn btn-primary mt-4" id="saveButton">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </>

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

        const encuestaFormulario = document.getElementById('encuestaForm');
        let fv;
        let table;
        const saveButton = document.getElementById('saveButton');

        document.addEventListener('DOMContentLoaded', () => {

            const table = new DataTable('#tableDocumentos', {
                ajax: {
                    url: "{{ role_route('documentosSoporte.list') }}",
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
                        data: 'nombre'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return row.usuario.name + " " + row.usuario.last_name;
                        }
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'tipo'
                    },
                    {
                        data: 'status',
                        render: function(data) {
                            // Cambia el texto del badge según el estado
                            switch (data) {
                                case 1:
                                    return `<span class="badge bg-label-success" text-capitalized>Públicado</span>`;
                                case 2:
                                    return `<span class="badge bg-label-warning" text-capitalized>No públicado</span>`;
                                case 0:
                                    return ''; // Omite "Eliminado"
                            }
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                        <button class="btn btn-sm btn-text-primary rounded-pill btn-icon" onclick="download(${row.id})" title="Descargar">
                            <i class="ti ti-download ti-md"></i>
                        </button>
                        <button class="btn btn-sm btn-text-danger rounded-pill btn-icon" onclick="eliminar(${row.id})" title="Eliminar">
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

        $('#encuestaModal').on('hidden.bs.modal', function() {
            document.getElementById('encuestaForm').reset();
            document.getElementById('id').value = 0;
            document.getElementById('cols-questions').innerHTML = '';
        });

        const form = document.getElementById('documentoForm');

        fv = FormValidation.formValidation(
                form, {
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

        saveButton.addEventListener('click', async function(e) {
            e.preventDefault();

            console.log("entrandoooooo");
            const status = await fv.validate();
            $("#contenido-view").waitMe({
                    effect: "win8_linear",
                    bg: "rgba(255,255,255,0.9)",
                    color: "#000",
                    textPos: "vertical",
                    fontSize: "250px",
                });
            if (status === 'Valid') {
                let formData = new FormData(document.getElementById('documentoForm'));
                try {
                    const response = await fetch('{{ role_route("documentosSoporte.save") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }
                    });

                    const responseData = await response.json();

                    if (responseData.success) {
                        table.ajax.reload();
                        $("#modalDocumento").modal('hide');
                        $('#contenido-view').waitMe("hide");

                        Swal.fire({
                            toast:true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            icon: "success",
                            timer: 3000,
                            title: responseData.message
                        });
                        document.getElementById('documentoForm').reset();
                        fv.resetForm();
                    } else {
                        $('#contenido-view').waitMe("hide");

                        Swal.fire({
                            toast:true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            icon: "error",
                            timer: 3000,
                            title: responseData.message
                        });
                    }
                } catch (error) {
                    console.error('Error al guardar los datos:', error);
                    $('#contenido-view').waitMe("hide");

                    Swal.fire({
                        toast:true,
                        position: "bottom-end",
                        showConfirmButton: false,
                        icon: "error",
                        timer: 3000,
                        title: 'Hubo un problema al guardar los datos.'
                    });
                }
            }else{
                console.log("No cumpleee");
                $('#contenido-view').waitMe("hide");

            }
        });
  
        function download(id) {
            fetch("{{ role_route('documentosSoporte.download', ':id') }}".replace(':id', id))
                .then(response => {
                    if (response.ok) {
                        const disposition = response.headers.get('Content-Disposition');
                        let filename = 'documento';

                        if (disposition && disposition.includes('filename=')) {
                            filename = disposition.split('filename=')[1].replace(/['"]/g, '');
                        }

                        return response.blob().then(blob => ({
                            blob,
                            filename
                        }));
                    } else {
                        throw new Error('Error al descargar el archivo');
                    }
                })
                .then(({
                    blob,
                    filename
                }) => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = filename; // Usar el nombre del archivo exacto
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('No se pudo descargar el archivo');
                });
        }

    </script>

@endsection
