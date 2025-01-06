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

        .dynamic-fields {
            margin-top: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Encuestas</h5>
            <button class="btn btn-primary" id="new-survey-btn" data-bs-toggle="modal" data-bs-target="#encuestaModal">+
                Nueva Encuesta</button>
        </div>

        <div class="card-body">
            <table class="table" id="tablaEncuestas">
                <thead class="border-top">
                    <tr>
                        <th>Titulo</th>
                        <th>Descripcion</th>
                        <th>Fecha Ejecución</th>
                        <th>Status</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="modal fade" id="encuestaModal" tabindex="-1" aria-labelledby="encuestaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="encuestaModalLabel">Nueva Encuesta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="encuestaForm" novalidate>

                            <input type="hidden" id="id" name="id">

                            <div class="row mb-3">
                                <div class="col-md-12 col-sm-12">
                                    <label for="titulo" class="form-label">Título de la encuesta:</label>
                                    <input type="text" id="titulo" name="titulo" class="form-control"
                                        placeholder="Encuesta ejemplo" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12 col-sm-12">
                                    <label for="fecha_inicio" class="form-label">Fecha Ejecución:</label>
                                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="descripcion" class="form-label">Descripción:</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="2" required></textarea>
                                </div>
                            </div>

                            <hr>

                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-4">
                                    <span class="">Datos generales</span>
                                </div>
                                <div class="col-md-1 text-end">
                                    <button type="button" id="add-field-group" class="btn btn-sm btn-primary"> + </button>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="dynamic-fields" id="dynamic-fields"></div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4">Guardar Encuesta</button>
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
        const addFieldGroupButton = document.getElementById('add-field-group');
        const dynamicFields = document.getElementById('dynamic-fields');

        const fv = FormValidation.formValidation(
            encuestaFormulario, {
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
            }
        );

        let table;

        const spanishTranslation = FormValidation.locales.es_ES;
        fv.setLocale('es_ES', spanishTranslation);

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
                        data: 'titulo'
                    },
                    {
                        data: 'descripcion'
                    },
                    {
                        data: 'fecha_inicio'
                    },
                    {
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

        const createFieldGroup = () => {
            const fieldGroup = document.createElement('div');
            fieldGroup.classList.add('field-group');

            fieldGroup.innerHTML = `
                                <div class="row align-items-end mt-4">

                                    <div class="col-md-4">
                                        <label for="name" class="form-label">Nombre o pregunta:</label>
                                        <input type="text" name="names[]" class="form-control" placeholder="Titulo" required>
                                    </div>


                                    <div class="col-md-3">
                                        <label for="type" class="form-label">Tipo pregunta:</label>
                                        <select name="types[]" class="form-select type-select">
                                            <option value="0">Selecciona tipo</option>
                                            <option value="1">Respuesta simple</option>
                                            <option value="2">Opciones múltiples</option>
                                        </select>
                                    </div>


                                    <div class="col-md-4 values-container" style="display: none;">
                                        <label for="values" class="form-label">Valores (por comas):</label>
                                        <input type="text" name="values[]" class="form-control dynamic-values" placeholder="Valor1, Valor2">
                                    </div>


                                    <div class="col-md-1 mb-1">
                                        <i class="menu-icon tf-icons ti ti-trash btn-remove"></i>
                                    </div>
                                </div>
                            `;
            const dynamicValuesInput = fieldGroup.querySelector('.dynamic-values');
            if (dynamicValuesInput) {
                new Tagify(dynamicValuesInput);
            }
            addEventsToFieldGroup(fieldGroup);
            dynamicFields.appendChild(fieldGroup);
        };

        const addEventsToFieldGroup = (fieldGroup) => {
            const typeSelect = fieldGroup.querySelector('.type-select');
            const valuesContainer = fieldGroup.querySelector('.values-container');

            typeSelect.addEventListener('change', () => {
                if (typeSelect.value === '2') {
                    valuesContainer.style.display = 'block';
                    console.log("Hola xx");
                } else {
                    valuesContainer.style.display = 'none';
                }
            });

            const removeButton = fieldGroup.querySelector('.btn-remove');
            removeButton.addEventListener('click', () => {
                fieldGroup.remove();
            });
        };

        addFieldGroupButton.addEventListener('click', () => {
            createFieldGroup();
        });

        $('#encuestaModal').on('hidden.bs.modal', function() {
            document.getElementById('encuestaForm').reset();
            dynamicFields.innerHTML = '';
            document.getElementById('id').value = 0;
            fv.resetForm();



        });

        encuestaFormulario.addEventListener('submit', (e) => {
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
                    const formData = new FormData(encuestaFormulario);
                    const surveyData = {
                        id: formData.get('id') || null,
                        titulo: formData.get('titulo'),
                        fecha_inicio: formData.get('fecha_inicio'),
                        descripcion: formData.get('descripcion'),
                        preguntas: []
                    };

                    const fieldGroups = dynamicFields.querySelectorAll('.field-group');

                    fieldGroups.forEach(group => {
                        const nameInput = group.querySelector('input[name="names[]"]');
                        const typeSelect = group.querySelector('select[name="types[]"]');
                        const valuesInput = group.querySelector('input[name="values[]"]');
                        const fieldData = {
                            name: nameInput.value,
                            type: typeSelect.value,
                            values: typeSelect.value === '2' ? JSON.parse(valuesInput.value)
                                .map(tag => tag.value).map(val => val.trim()) : []
                        };

                        surveyData.preguntas.push(fieldData);
                    });

                    fetch("{{ role_route('encuestas.save') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                            },
                            body: JSON.stringify(surveyData) // Convertir datos a JSON
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Error en la solicitud');
                            }
                            return response.json();
                        })
                        .then(data => {
                            $('#contenido-view').waitMe("hide");
                            Swal.fire({
                                toast: true,
                                position: "bottom-end",
                                showConfirmButton: false,
                                icon: "success",
                                timer: 3000,
                                title: 'Correcto !!'
                            });
                            $("#encuestaModal").modal('hide');
                            table.ajax.reload();
                            encuestaFormulario.reset(); // Reiniciar el formulario
                            dynamicFields.innerHTML = ''; // Limpiar campos dinámicos
                        })
                        .catch(error => {
                            $('#contenido-view').waitMe("hide");
                            Swal.fire({
                                toast: true,
                                position: "bottom-end",
                                showConfirmButton: false,
                                icon: "error",
                                timer: 3000,
                                title: 'Error intentelo nuevamente .'
                            });
                        });

                }else{
                    $('#contenido-view').waitMe("hide");
                }
            })

        });

        function editar(id) {
            // Busca el registro específico
            let url = `{{ role_route('encuestas.edit', ':id') }}`;
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
                    document.getElementById('id').value = data.id;
                    document.getElementById('titulo').value = data.titulo;
                    document.getElementById('descripcion').value = data.descripcion;
                    document.getElementById('fecha_inicio').value = data.fecha_inicio;

                    // Limpia campos dinámicos
                    const dynamicFields = document.getElementById('dynamic-fields');
                    dynamicFields.innerHTML = '';

                    let contenido = [];
                    try {
                        contenido = JSON.parse(data.contenido);
                    } catch (e) {
                        console.error('El contenido no es un JSON válido:', e);
                    }

                    contenido.forEach(item => {
                        const fieldGroup = document.createElement('div');
                        fieldGroup.classList.add('field-group');
                        fieldGroup.innerHTML = `
                            <div class="row align-items-end mt-4">
                                <div class="col-md-4">
                                    <label for="name" class="form-label">Nombre o pregunta:</label>
                                    <input type="text" name="names[]" class="form-control" value="${item.name}" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="type" class="form-label">Tipo pregunta:</label>
                                    <select name="types[]" class="form-select type-select">
                                        <option value="1" ${item.type === "1" ? "selected" : ""}>Respuesta simple</option>
                                        <option value="2" ${item.type === "2" ? "selected" : ""}>Opciones múltiples</option>
                                    </select>
                                </div>
                                <div class="col-md-4 values-container" style="${item.type === "2" ? "display: block;" : "display: none;"}">
                                    <label for="values" class="form-label">Valores (por comas):</label>
                                    <input type="text" name="values[]" class="form-control dynamic-values" value="">
                                </div>
                                <div class="col-md-1">
                                    <i class="menu-icon tf-icons ti ti-trash btn-remove"></i>
                                </div>
                            </div>`;

                        // Agregar eventos
                        addEventsToFieldGroup(fieldGroup);

                        // Agregar el campo al DOM
                        dynamicFields.appendChild(fieldGroup);

                        // Inicializa Tagify en el campo de valores (si es tipo 2)
                        if (item.type === "2") {
                            const valuesInput = fieldGroup.querySelector('.dynamic-values');
                            new Tagify(valuesInput).addTags(item
                                .values); // Pasa los valores del backend a Tagify
                        }
                    });

                    // Muestra el modal
                    $("#encuestaModal").modal('show');
                })
                .catch(error => console.error('Error al cargar los datos:', error));
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
                    let url = `{{ role_route('encuestas.delete', ':id') }}`;
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
