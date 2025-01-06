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
            <h5 class="card-title mb-0">Formatos</h5>
            <button class="btn btn-primary" id="new-survey-btn" data-bs-toggle="modal" data-bs-target="#encuestaModal">+
                Nuevo Formato</button>
        </div>

        <div class="card-body">
            <table class="table" id="tablaEncuestas">
                <thead class="border-top">
                    <tr>
                        <th>Titulo</th>
                        <th>Fecha Creación</th>
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
                        <h5 class="modal-title" id="encuestaModalLabel">Nuevo formato</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="encuestaForm" novalidate>

                            <input type="hidden" id="id" name="id" value="0">

                            <div class="row mb-3">
                                <div class="col-md-12 col-sm-12">
                                    <label for="titulo" class="form-label">Nombre formato:</label>
                                    <input type="text" id="formato" name="formato" class="form-control"
                                        placeholder="Nombre formato" required>
                                </div>
                            </div>

                            <hr>

                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-4">
                                    <span class="">Opciones generales</span>
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
                    url: "{{ role_route('formatos.list') }}",
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
                                        <label for="name" class="form-label">Nombre campo:</label>
                                        <input type="text" name="names[]" class="form-control" placeholder="Titulo" required>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="type" class="form-label">Tipo campo:</label>
                                        <select name="types[]" class="form-select type-select">
                                            <option value="0">Selecciona tipo</option>
                                            <option value="1">Texto</option>
                                            <option value="2">Fecha</option>
                                            <option value="3">Documento/Imagen</option>
                                            <option value="4">Comentario simple</option>
                                            <option value="5">Comentario multiple</option>
                                            <option value="6">Hora</option>
                                            <option value="7">Seleccionable</option>

                                        </select>
                                    </div>
                                    <div class="col-md-4 values-container" style="display: none;">
                                        <label for="values" class="form-label">Opciones seleccionables:</label>
                                        <input type="text" name="values[]" class="form-control dynamic-values" placeholder="Opcion1, Opcion2">
                                    </div>
                                      <div class="col-md-4 horas-container" style="display: none;">
                                        <label for="values" class="form-label">Opciones seleccionables:</label>
                                        <input type="number" name="maximo_comentario[]" class="form-control" placeholder="4">
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
            const horasContainer = fieldGroup.querySelector('.horas-container');

            const caseMap = {
                '7': valuesContainer,
                '5': horasContainer,
            };

            typeSelect.addEventListener('change', () => {
                // Ocultar todos los contenedores inicialmente
                Object.values(caseMap).forEach(container => {
                    container.style.display = 'none';
                });

                // Mostrar solo el contenedor correspondiente
                const selectedContainer = caseMap[typeSelect.value];
                if (selectedContainer) {
                    selectedContainer.style.display = 'block';
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
            console.log("saliendoooooooo");
            encuestaFormulario.reset();
            document.getElementById('id').value = 0;
            dynamicFields.innerHTML = '';

        });

        encuestaFormulario.addEventListener('submit', (e) => {
            e.preventDefault();
            // Iniciar el spinner de espera
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
                        titulo: formData.get('formato'),
                        fecha_inicio: formData.get('fecha_inicio'),
                        preguntas: []
                    };

                    const fieldGroups = dynamicFields.querySelectorAll('.field-group');

                    fieldGroups.forEach(group => {
                        const nameInput = group.querySelector('input[name="names[]"]');
                        const typeSelect = group.querySelector('select[name="types[]"]');
                        const valuesInput = group.querySelector('input[name="values[]"]');
                        const horasInput = group.querySelector('input[name="maximo_comentario[]"]');

                        const fieldData = {
                            name: nameInput ? nameInput.value : null,
                            type: typeSelect ? typeSelect.value : null,
                            values: [],
                            maximoComentario: null,
                        };

                        // Manejar valores basados en el tipo
                        switch (typeSelect.value) {
                            case '7': // Caso para `values-container`
                                if (valuesInput) {
                                    fieldData.values = JSON.parse(valuesInput.value)
                                        .map(tag => tag.value).map(val => val.trim()) || [];
                                }
                                break;

                            case '5': // Caso para `horas-container`
                                if (horasInput) {
                                    fieldData.maximoComentario = parseInt(horasInput.value, 10) ||
                                        0; // Almacenar número como entero
                                }
                                break;

                            default:
                                // Otros casos personalizados o valores por defecto
                                break;
                        }

                        // Agregar el objeto al array de preguntas
                        surveyData.preguntas.push(fieldData);
                    });

                    fetch("{{ role_route('formatos.save') }}", {
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




                } else {
                    $('#contenido-view').waitMe("hide"); // Si la validación falla, ocultar el spinner
                }
            })

        });

        function editar(id) {
            // Busca el registro específico
            let url = `{{ role_route('formatos.edit', ':id') }}`;
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
                    document.getElementById('formato').value = data.titulo;

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
                                <option value="1" ${item.type === "1" ? "selected" : ""}>Texto</option>
                                <option value="2" ${item.type === "2" ? "selected" : ""}>Fecha</option>
                                <option value="3" ${item.type === "3" ? "selected" : ""}>Documento/Imagen</option>
                                <option value="4" ${item.type === "4" ? "selected" : ""}>Comentario simple</option>
                                <option value="5" ${item.type === "5" ? "selected" : ""}>Comentario múltiple</option>
                                <option value="6" ${item.type === "6" ? "selected" : ""}>Hora</option>
                                <option value="7" ${item.type === "7" ? "selected" : ""}>Seleccionable</option>
                            </select>
                        </div>
                        <div class="col-md-4 values-container" style="${item.type === "7" ? "display: block;" : "display: none;"}">
                            <label for="values" class="form-label">Valores (por comas):</label>
                            <input type="text" name="values[]" class="form-control dynamic-values" value="">
                        </div>
                        <div class="col-md-4 horas-container" style="${item.type === "5" ? "display: block;" : "display: none;"}">
                            <label for="maximo_comentario" class="form-label">Máximo comentario:</label>
                            <input type="number" name="maximo_comentario[]" class="form-control" value="${item.maximoComentario || ''}">
                        </div>
                        <div class="col-md-1">
                            <i class="menu-icon tf-icons ti ti-trash btn-remove"></i>
                        </div>
                    </div>`;

                        // Agregar eventos
                        addEventsToFieldGroup(fieldGroup);

                        // Agregar el campo al DOM
                        dynamicFields.appendChild(fieldGroup);

                        // Inicializa Tagify en el campo de valores (si es tipo seleccionable)
                        if (item.type === "7") {
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
                    let url = `{{ role_route('formatos.delete', ':id') }}`;
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
