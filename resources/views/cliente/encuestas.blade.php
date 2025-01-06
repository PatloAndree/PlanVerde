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
            <h5 class="card-title mb-0">Encuestas</h5>
            <button class="btn btn-primary d-none" id="new-survey-btn" data-bs-toggle="modal" data-bs-target="#encuestaModal">+ Nueva Encuesta</button>
        </div>

        <div class="card-body">
            <table class="table" id="tablaEncuestas">
                <thead class="border-top">
                    <tr>
                        <th>Titulo</th>
                        <th>Fecha Respuesta</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="modal fade" id="encuestaModal" tabindex="-1" aria-labelledby="encuestaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="encuestaModalLabel" style="text-transform: uppercase">Nueva Encuesta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="encuestaForm" novalidate>
                            <input type="hidden" id="encuestacliente_id" name="encuestacliente_id">
                            <input type="hidden" id="encuesta_id" name="encuesta_id">
                            <input type="hidden" id="empresa_id" name="empresa_id">
                            <input type="hidden" id="cliente_id" name="cliente_id">
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="alert alert-warning" id="descripcion" role="alert"></div>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-4" id="cols-questions">

                            </div>
                            <div class="row">
                                <div class="col-md-12 text-end" id="divSaveEncuesta">
                                    <button type="submit" class="btn btn-primary mt-4" id="saveEncuesta">Guardar Encuesta</button>
                                </div>
                                <div class="col-md-12 text-end" id="divCloseEncuesta">
                                    <button type="button" class="btn btn-secondary mt-4" id="closeEncuesta">Cerrar</button>
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
        const encuestaFormulario = document.getElementById('encuestaForm');
        let fv;
        let table;

        document.addEventListener('DOMContentLoaded', () => {

            table = new DataTable('#tablaEncuestas', {
                // Configuración de DataTable
                ajax: {
                    url: "{{ role_route('encuestas.list') }}",
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
                        data: 'encuesta_preguntas',
                        render: function(data) {
                            let encuesta = JSON.parse(data);
                            return encuesta.titulo;
                        }
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'status',
                        render: function(data) {
                            // Cambia el texto del badge según el estado
                            switch (data) {
                                case 1:
                                    return `<span class="badge bg-label-success" text-capitalized>Realizado</span>`;
                                case 2:
                                    return `<span class="badge bg-label-warning" text-capitalized>Pendiente</span>`;
                                case 0:
                                    return ''; // Omite "Eliminado"
                            }
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            let icon = '';
                            let tooltip = '';

                            if (row.status === 1) {
                                icon = '<i class="ti ti-eye ti-md"></i>';
                                tooltip = 'Ver';
                            } else if (row.status === 2) {
                                icon = '<i class="ti ti-pencil ti-md"></i>';
                                tooltip = 'Editar';
                            }

                            return `
                                <button class="btn btn-sm btn-text-warning rounded-pill btn-icon" onclick="editar(${row.encuesta_id},${row.id})" title="${tooltip}">
                                    ${icon}
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

        encuestaFormulario.addEventListener('submit', async (e) => {
            e.preventDefault(); // Prevenir el comportamiento predeterminado del formulario

            // Iniciar el spinner de espera
            $("#contenido-view").waitMe({
                effect: "win8_linear",
                bg: "rgba(255,255,255,0.9)",
                color: "#000",
                textPos: "vertical",
                fontSize: "250px",
            });

            try {
                // Esperar a que la validación se complete
                const status = await fv.validate(); // Usa await aquí para esperar la validación

                if (status === 'Valid') {
                    // Recolectar los valores del formulario
                    const encuestaclienteId = document.getElementById('encuestacliente_id').value;
                    const encuestaId = document.getElementById('encuesta_id').value;
                    const empresaId = document.getElementById('empresa_id').value;
                    const clienteId = document.getElementById('cliente_id').value;
                    const encuestaModalLabel = document.getElementById('encuestaModalLabel').innerHTML;
                    const descripcion = document.getElementById('descripcion').innerHTML;

                    const formData = new FormData(encuestaFormulario);
                    const surveyData = {
                        encuestaclienteId: encuestaclienteId,
                        encuestaId: encuestaId,
                        empresaId: empresaId,
                        clienteId: clienteId,
                        titulo: encuestaModalLabel,
                        descripcion: descripcion,
                        preguntas: []
                    };

                    // Recolectar las preguntas del formulario
                    const questionsContainer = document.getElementById('cols-questions');
                    const questionGroups = questionsContainer.querySelectorAll('.col-12 .mb-3');

                    questionGroups.forEach(group => {
                        const label = group.querySelector('label');
                        const input = group.querySelector('input, select');
                        const name = input.name;
                        const type = input.tagName === 'INPUT' ? '1' : '2';

                        let values = null;
                        let response = null;

                        if (type === '1') {
                            response = input.value.trim() || null;
                        } else if (type === '2') {
                            const options = Array.from(input.options).map(option => option.value);
                            values = options.filter(value => value);
                            response = input.value || null;
                        }

                        surveyData.preguntas.push({
                            name: name,
                            type: type,
                            values: values,
                            response: response
                        });
                    });

                    // Hacer la solicitud con fetch
                    const response = await fetch("{{ role_route('encuestas.save') }}", {
                        method: 'POST',
                        body: JSON.stringify(surveyData),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type': 'application/json' // Asegúrate de enviar el tipo correcto de contenido
                        }
                    });

                    const responseData = await response.json(); // Esperar la respuesta de la solicitud

                    if (responseData.success) {
                        Swal.fire({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            icon: "success",
                            timer: 3000,
                            title: responseData.message
                        });
                        $('#contenido-view').waitMe("hide"); // Ocultar el spinner
                        table.ajax.reload();
                        $("#encuestaModal").modal('hide');
                    } else {
                        Swal.fire({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            icon: "error",
                            timer: 3000,
                            title: responseData.message
                        });
                        $('#contenido-view').waitMe("hide"); // Ocultar el spinner
                    }
                } else {
                    $('#contenido-view').waitMe("hide"); // Si la validación falla, ocultar el spinner
                }
            } catch (error) {
                console.error('Error al guardar los datos:', error);
                Swal.fire({
                    toast: true,
                    position: "bottom-end",
                    showConfirmButton: false,
                    icon: "error",
                    timer: 3000,
                    title: 'Ocurrió un problema.'
                });
                $('#contenido-view').waitMe("hide"); // Ocultar el spinner en caso de error
            }
        });


        function editar(encuesta_id,encuestacliente_id = 0) {
            // Busca el registro específico
            encuestacliente_id = (encuestacliente_id == null) ? 0 : encuestacliente_id;
            let url = `{{ route('cliente.encuestas.edit', [':encuestaId', ':encuestaClienteId']) }}`;
            url = url.replace(':encuestaId', encuesta_id);
            url = url.replace(':encuestaClienteId', encuestacliente_id);

            fetch(url)
                .then(response => response.json())
                .then(result => {
                    const data = result.data;

                    if (!data) {
                        console.error('No se encontró la encuesta.');
                        return;
                    }
                    let encuesta = (data.encuesta_respuestas == null ) ? JSON.parse(data.encuesta_preguntas) : JSON.parse(data.encuesta_respuestas);
                    disabled = (data.encuesta_respuestas == null ) ? '' : 'disabled';


                    // Carga valores básicos
                    document.getElementById('encuestacliente_id').value = (data.id == null) ? 0 : data.id;
                    document.getElementById('encuesta_id').value = data.encuesta_id;
                    document.getElementById('empresa_id').value = data.empresa_id;
                    document.getElementById('cliente_id').value = data.user_id;
                    document.getElementById('encuestaModalLabel').innerHTML = encuesta.titulo;
                    document.getElementById('descripcion').innerHTML = encuesta.descripcion;

                    //FOREACH PREGUNTAS
                    const preguntas = JSON.parse(encuesta.contenido);
                    let htmlPreguntas = '';
                    preguntas.forEach(element => {
                        let typeInput = '';
                        const nameForAttribute = element.name;
                        console.log(element);
                        if(element.type == 1){
                            typeInput=`<label for="${nameForAttribute}" class="form-label" style="text-transform: uppercase">${element.name}</label>
                                    <input type="text" class="form-control" id="${nameForAttribute}" value="${(element.response) ?? ''}" name="${nameForAttribute}" ${disabled} required>`;
                        }else if(element.type == 2){
                            const values = element.values;
                            let selectOption = '<option value="" style="text-transform: uppercase">Seleccionar</option>';
                            values.forEach(options => {
                                const isSelected = (element.response && element.response === options) ? 'selected' : '';

                                selectOption += `<option value="${options}" style="text-transform: uppercase" ${isSelected}>${options}</option>`
                            });
                            typeInput=`<label for="${nameForAttribute}" class="form-label" style="text-transform: uppercase">${element.name}</label>
                                        <select class="form-select" name="${nameForAttribute}" id="${nameForAttribute}" ${disabled} required>${selectOption}</select>`
                        }
                        htmlPreguntas+=`<div class="col-12"><div class="mb-3">${typeInput}</div></div>`;
                    });
                    document.getElementById('cols-questions').innerHTML = htmlPreguntas;

                    if (fv) {
                        fv.destroy();
                        fv = null;
                    }

                    const encuestaForm = document.getElementById('encuestaForm');
                    fv = FormValidation.formValidation(encuestaForm, {
                        fields: {},
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            declarative: new FormValidation.plugins.Declarative({
                                html5Input: true,
                            }),
                            bootstrap5: new FormValidation.plugins.Bootstrap5({
                                eleInvalidClass: 'is-invalid',
                                eleValidClass: "",
                            }),
                        },
                    });

                    const spanishTranslation = FormValidation.locales.es_ES;
                    fv.setLocale('es_ES', spanishTranslation);
                    if (disabled == '') {
                        document.getElementById("divSaveEncuesta").style.display = 'block';
                        document.getElementById("divCloseEncuesta").style.display = 'none';
                    } else {
                        document.getElementById("divSaveEncuesta").style.display = 'none';
                        document.getElementById("divCloseEncuesta").style.display = 'block';
                    }
                    $("#encuestaModal").modal('show');
                })
                .catch(error => console.error('Error al cargar los datos:', error));
        }

       


        document.getElementById('closeEncuesta').addEventListener('click', function() {
            $('#encuestaModal').modal('hide');
        });



    </script>
@endsection
