@extends('template.template')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/waitMe.css') }}" />

    <style>
        #calendar {
            max-width: 100%;
            margin: 0 auto;
        }

        #preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .image-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .preview-image {
            width: 100px;
            height: 100px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .btn {
            margin-top: 5px;
        }

        .fc-event {
            border: none; /* Elimina el borde si es necesario */
            cursor: pointer;
            background-color:#92B728;
            height:20px;
        }

        
    </style>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Actividades</h5>
        </div>

        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>

    <div class="modal fade" id="calendarModalCrear" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="calendarModalLabel">Nueva Actividad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="actividadForm" novalidate>
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título de la actividad</label>
                            <input type="text" class="form-control" id="titulo" name="titulo"
                                placeholder="Nombre de la actividad" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select class="form-select" aria-label="Default select example" name="tipo" id="tipo"
                                required>
                                <option selected>Selecciona tipo actividad</option>
                                <option value="1">Capacitación</option>
                                <option value="2">Mantenimiento</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea name="descripcion" id="descripcion" cols="4" name="descripcion" class="form-control" required></textarea >
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Imagenes de actividad</label>
                            <input type="file" class="form-control" id="image" name="image[]" accept="image/*"
                                multiple >
                        </div>

                        <div id="preview-container"></div>

                        <div class="mb-1">
                        </div>
                        <hr>

                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha inicio actividad</label>
                            <input type="datetime-local" class="form-control bg-light" id="fecha_inicio" name="fecha_inicio"
                                readonly required>
                        </div>

                        <div class="mb-3">
                            <label for="fecha_fin" class="form-label">Fecha fin actividad</label>
                            <input type="datetime-local" id="fecha_fin" name="fecha_fin" value=""
                                class="form-control" required />
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" id="guardarActividad" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="calendarModalEditar" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="calendarModalLabel">Nueva Actividad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="actividadEditar">
                        <input type="text" name="actividad_id_edit" id="actividad_id_edit"
                            class="form-control d-none" value="">

                        <div class="mb-3">
                            <label for="eventTitle" class="form-label">Título de la actividad</label>
                            <input type="text" class="form-control" id="titulo_edit" name="titulo_edit"
                                placeholder="Nombre de la actividad">
                        </div>
                        <div class="mb-3">
                            <label for="eventTitle" class="form-label">Tipo</label>
                            <select class="form-select" aria-label="Default select example" name="tipo_edit"
                                id="tipo_edit">
                                <option selected>Selecciona complejidad</option>
                                <option value="1">Capacitación</option>
                                <option value="2">Mantenimiento</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="eventTitle" class="form-label">Descripción</label>
                            <textarea id="descripcion_edit" cols="4" name="descripcion_edit" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label">Imagenes de actividad</label>
                            <input type="file" class="form-control" id="image_edit" name="image_edit[]"
                                accept="image/*" multiple>
                        </div>

                        <div id="preview-container-edit"></div>

                        <div class="mb-1">
                        </div>
                        <hr>

                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha inicio actividad</label>
                            <input type="datetime-local" class="form-control bg-light" id="fecha_inicio_edit"
                                name="fecha_inicio_edit" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_fin" class="form-label">Fecha fin actividad</label>
                            <input type="datetime-local" id="fecha_fin_edit" name="fecha_fin_edit" value=""
                                class="form-control" />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="eliminarActividad">
                        <i class="ti ti-trash ti-md"></i>
                    </button>
                    <button type="button" id="editarActividad" class="btn btn-primary">Editar</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('js/index.global.js') }}"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js'></script>
    <script src="https://formvalidation.io//vendors/@form-validation/umd/locales/es_ES.min.js"></script>
    <script src="{{ asset('js/waitMe.js') }}"></script>

@endsection

@section('implemetenciones')
    <script>
        const modalElement = document.getElementById('calendarModalCrear');
        modalElement.addEventListener('hidden.bs.modal', function() {
            document.getElementById('actividadForm').reset();
            const previewContainer = document.getElementById('preview-container');
            if (previewContainer) {
                previewContainer.innerHTML = '';
            }
        });

        const calendarEl = document.getElementById('calendar');
        let actividades = @json($actividades);

        const eventos = actividades.map(actividad => {
            const fotos = actividad.actividades_fotos.map(foto => {
                return {
                    id: foto.id,
                    file_path: foto.file_path
                };
            });
            return {
                title: actividad.titulo,
                start: actividad.fecha_inicio,
                end: actividad.fecha_final,
                id: actividad.id,
                descripcion: actividad.descripcion,
                tipo: actividad.tipo,
                fotos: fotos,

            };
        });

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            timeZone: 'America/Lima',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            },
            themeSystem: 'bootstrap',
            locale: 'es',
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día',
                list: 'Agenda'
            },
            events: eventos,
            dateClick: function(info) {
                const dateTimeStr = `${info.dateStr}T12:00`;
                document.getElementById('fecha_inicio').value = dateTimeStr;
                const NuevaActividad = new bootstrap.Modal(document.getElementById(
                    'calendarModalCrear'));
                NuevaActividad.show();
            },
            eventClick: function(info) {
                const event = info.event;
                console.log(event);
                const actividadId = event.id;
                console.log("Soye activividad", actividadId);
                const modal = new bootstrap.Modal(document.getElementById('calendarModalEditar'));
                document.getElementById('titulo_edit').value = event.title;
                document.getElementById('fecha_inicio_edit').value = event.start.toISOString()
                    .slice(0, 16);
                document.getElementById('fecha_fin_edit').value = event.end ? event.end
                    .toISOString().slice(0, 16) : '';
                document.getElementById('descripcion_edit').value = event.extendedProps.descripcion;
                document.getElementById('tipo_edit').value = event.extendedProps.tipo;
                document.getElementById('actividad_id_edit').value = actividadId;

                const imageContainer = document.getElementById('preview-container-edit');
                imageContainer.innerHTML = '';
                if (event.extendedProps.fotos && event.extendedProps.fotos.length > 0) {
                    event.extendedProps.fotos.forEach(foto => {
                        const container = document.createElement('div');
                        container.classList.add('image-container', 'position-relative',
                            'd-inline-block', 'me-2', 'mb-2');
                        const imgElement = document.createElement('img');
                        imgElement.src = `/storage/${foto.file_path}`;
                        imgElement.classList.add('preview-image', 'image-container');
                        imgElement.setAttribute('data-id', foto.id);
                        const deleteButton = document.createElement('span');
                        deleteButton.classList.add('delete-icon', 'text-danger',
                            'cursor-pointer', 'position-absolute', 'top-0', 'end-0',
                            'm-2');
                        deleteButton.innerHTML = '<i class="ti ti-trash ti-md"></i>';

                        deleteButton.addEventListener('click', function() {
                            const idActividad = document.getElementById('actividad_id_edit');
                            const imageId = imgElement.getAttribute('data-id');
                            console.log(imageId);
                            const deleteImageUrl =
                                "{{ route('actividadImagen.delete', ':id') }}";
                            const urlConId = deleteImageUrl.replace(':id', imageId);

                            fetch(urlConId, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content'),
                                    },
                                    body: JSON.stringify({
                                        actividad_id: actividadId,
                                        imagen_id: imageId
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        container.remove();
                                        fetch('{{ route('actividades.listado') }}')
                                            .then(response => response.json())
                                            .then(actividadesActualizadas => {
                                                actividades = actividadesActualizadas;
                                                reloadCalendar();
                                            })
                                            .catch(error => {
                                                console.error(
                                                    'Error al recargar las actividades:',
                                                    error);
                                            });
                                    } else {
                                        console.error('Error al eliminar la imagen');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error en la solicitud:', error);
                                });

                        });
                        container.appendChild(imgElement);
                        container.appendChild(deleteButton);

                        imageContainer.appendChild(container);
                    });
                } else {
                    imageContainer.innerHTML =
                        '<p>No hay imágenes disponibles para esta actividad.</p>';
                }
                modal.show();
            },
            eventContent: function(info) {
                return {
                    html: `<span class="text-white ms-2 "> ${info.event.title }</span>`
                };
            }
        });

        function reloadCalendar() {
            calendar.getEvents().forEach(event => event.remove());
            const eventos = actividades.map(actividad => {
                const fotos = actividad.actividades_fotos.map(foto => {
                    return {
                        id: foto.id,
                        file_path: foto.file_path
                    };
                });
                return {
                    title: actividad.titulo,
                    start: actividad.fecha_inicio,
                    end: actividad.fecha_final,
                    id: actividad.id,
                    descripcion: actividad.descripcion,
                    tipo: actividad.tipo,
                    fotos: fotos
                };
            });
            eventos.forEach(event => calendar.addEvent(event));
        }
        calendar.render();

        document.addEventListener('DOMContentLoaded', function() {

        });


        const fv = FormValidation.formValidation(
            document.getElementById('actividadForm'), // Asegúrate de que el ID coincida con el del formulario
            {
                fields: {
                    titulo: {
                        validators: {
                            notEmpty: {
                                message: 'El título es obligatorio'
                            }
                        }
                    },
                    tipo: {
                        validators: {
                            notEmpty: {
                                message: 'El tipo de actividad es obligatorio'
                            }
                        }
                    },
                    descripcion: {
                        validators: {
                            notEmpty: {
                                message: 'La descripción es obligatoria'
                            }
                        }
                    },
                    fecha_fin: {
                        validators: {
                            notEmpty: {
                                message: 'La fecha de fin es obligatoria'
                            },
                            callback: {
                                message: 'La fecha de fin tiene que ser mayor a la fecha de inicio',
                                callback: function(input) {
                                    const fechaInicio = document.getElementById('fecha_inicio').value;
                                    const fechaFin = input.value;

                                    // Comprobar que ambas fechas existen
                                    if (!fechaInicio || !fechaFin) {
                                        return true; // Si uno de los campos está vacío, no validar esta regla
                                    }

                                    // Convertir las fechas a objetos Date
                                    const startDate = new Date(fechaInicio);
                                    const endDate = new Date(fechaFin);

                                    // Validar que la fecha de fin sea mayor que la fecha de inicio
                                    return endDate > startDate;
                                }
                            }
                        }
                    }
                },
                plugins: {
                    // Usa solo los plugins necesarios para la prueba
                    trigger: new FormValidation.plugins.Trigger(),
                    declarative: new FormValidation.plugins.Declarative({
                        html5Input: true,
                    }),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.mb-3',
                        eleInvalidClass: 'is-invalid',
                        eleValidClass: '',
                    }),
                },
            }
        ).on('core.field.invalid', function(e) {
            if (e.element) {
                e.element.classList.add('is-invalid');
                e.element.classList.remove('is-valid');
            }
        }).on('core.field.valid', function(e) {
            if (e.element) {
                e.element.classList.remove('is-invalid');
                e.element.classList.add('is-valid');
            }
        });

        const spanishTranslation = FormValidation.locales.es_ES;
        fv.setLocale('es_ES', spanishTranslation);

        const fv2 = FormValidation.formValidation(
            document.getElementById('actividadEditar'), // Asegúrate de que el ID coincida con el del formulario
            {
                fields: {
                    titulo_edit: {
                        validators: {
                            notEmpty: {
                                message: 'El título es obligatorio'
                            }
                        }
                    },
                    tipo_edit: {
                        validators: {
                            notEmpty: {
                                message: 'El tipo de actividad es obligatorio'
                            }
                        }
                    },
                    descripcion_edit: {
                        validators: {
                            notEmpty: {
                                message: 'La descripción es obligatoria'
                            }
                        }
                    },
                    fecha_fin_edit: {
                        validators: {
                            notEmpty: {
                                message: 'La fecha de fin es obligatoria'
                            },
                            callback: {
                                message: 'La fecha de fin tiene que ser mayor a la fecha de inicio',
                                callback: function(input) {
                                    const fechaInicio = document.getElementById('fecha_inicio_edit').value;
                                    const fechaFin = input.value;

                                    // Comprobar que ambas fechas existen
                                    if (!fechaInicio || !fechaFin) {
                                        return true; // Si uno de los campos está vacío, no validar esta regla
                                    }

                                    // Convertir las fechas a objetos Date
                                    const startDate = new Date(fechaInicio);
                                    const endDate = new Date(fechaFin);

                                    // Validar que la fecha de fin sea mayor que la fecha de inicio
                                    return endDate > startDate;
                                }
                            }
                        }
                    }
                },
                plugins: {
                    // Usa solo los plugins necesarios para la prueba
                    trigger: new FormValidation.plugins.Trigger(),
                    declarative: new FormValidation.plugins.Declarative({
                        html5Input: true,
                    }),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.mb-3',
                        eleInvalidClass: 'is-invalid',
                        eleValidClass: '',
                    }),
                },
            }
        ).on('core.field.invalid', function(e) {
            if (e.element) {
                e.element.classList.add('is-invalid');
                e.element.classList.remove('is-valid');
            }
        }).on('core.field.valid', function(e) {
            if (e.element) {
                e.element.classList.remove('is-invalid');
                e.element.classList.add('is-valid');
            }
        });

        const spanishTranslation2 = FormValidation.locales.es_ES;
        fv2.setLocale('es_ES', spanishTranslation2);


        $('#calendarModalCrear').on('hidden.bs.modal', function() {
            // reloadCalendar();
            document.getElementById('actividadForm').reset();
            fv.resetForm();

        });

        $('#calendarModalEditar').on('hidden.bs.modal', function() {
            // reloadCalendar();
            document.getElementById('actividadEditar').reset();
            console.log("saliendo");
            fv2.resetForm();

        });




        document.getElementById('image').addEventListener('change', function(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('preview-container');
            const noImagesMessage = document.getElementById('no-images');
            if (previewContainer) {
                if (noImagesMessage) {
                    noImagesMessage.style.display = 'none';
                }

                Array.from(files).forEach(file => {
                    if (file) {
                        const container = document.createElement('div');
                        container.classList.add('image-container', 'position-relative',
                            'd-inline-block', 'me-2', 'mb-2');

                        const imgElement = document.createElement('img');
                        imgElement.classList.add('preview-image');

                        const url = URL.createObjectURL(file);
                        imgElement.src = url;

                        const deleteButton = document.createElement('span');

                        deleteButton.classList.add('delete-icon', 'text-danger',
                            'cursor-pointer', 'position-absolute', 'top-0', 'end-0',
                            'm-2');
                        deleteButton.innerHTML = '<i class="ti ti-trash ti-md"></i>';
                        deleteButton.addEventListener('click', function() {
                            container
                                .remove();
                        });

                        container.appendChild(imgElement);
                        container.appendChild(deleteButton);


                        previewContainer.appendChild(container);
                    }
                });
            }
        });

        document.getElementById('image_edit').addEventListener('change', function(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('preview-container-edit');

            const noImagesMessage = document.getElementById('no-images');
            if (noImagesMessage) {
                noImagesMessage.style.display = 'none';
            }

            Array.from(files).forEach(file => {
                if (file) {
                    const container = document.createElement('div');
                    container.classList.add('image-container', 'position-relative',
                        'd-inline-block', 'me-2', 'mb-2');

                    const imgElement = document.createElement('img');
                    imgElement.classList.add('preview-image', 'image-container');

                    const url = URL.createObjectURL(file);
                    imgElement.src = url;

                    const deleteButton = document.createElement('span');
                    deleteButton.classList.add('delete-icon', 'text-danger', 'cursor-pointer',
                        'position-absolute', 'top-0', 'end-0', 'm-2');
                    deleteButton.innerHTML = '<i class="ti ti-trash ti-md"></i>';
                    deleteButton.addEventListener('click', function() {
                        container.remove();
                    });
                    container.appendChild(imgElement);
                    container.appendChild(deleteButton);

                    previewContainer.appendChild(container);
                }
            });
        });

        document.getElementById('guardarActividad').addEventListener('click', async function() {
            const form = document.getElementById('actividadForm');
            const status = await fv.validate();
            $("#contenido-view").waitMe({
                effect: "win8_linear",
                bg: "rgba(255,255,255,0.9)",
                color: "#000",
                textPos: "vertical",
                fontSize: "250px",
            });
            if (status === 'Valid') {
                const formData = new FormData(document.getElementById('actividadForm'));

                fetch('{{ route('actividades.save') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                        }
                    })
                    .then(response => {
                        $('#contenido-view').waitMe("hide");
                        if (!response.ok) {
                            return response.json().then(errorData => {
                                throw errorData;
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            icon: "success",
                            timer: 3000,
                            title: 'Exito actividad guardada !'
                        });
                        $('#contenido-view').waitMe("hide");

                        fetch('{{ route('actividades.listado') }}')
                            .then(response => response.json())
                            .then(actividadesActualizadas => {
                                actividades = actividadesActualizadas;
                                reloadCalendar();
                            })
                            .catch(error => {
                                // console.error('Error al recargar las actividades:', error);
                            });
                        const myModalEl = document.getElementById('calendarModalCrear');
                        const modalInstance = bootstrap.Modal.getInstance(myModalEl);
                        modalInstance.hide();
                        form.reset();
                    })
                    .catch(error => {
                        console.error('Error al guardar los datos:', error);
                        $('#contenido-view').waitMe("hide");
                        Swal.fire({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            icon: "error",
                            timer: 3000,
                            title: 'Error en la solicitud'
                        });
                    });
            } else {
                console.log("No entro");
            }

        });

        document.getElementById('editarActividad').addEventListener('click', async function() {
            const form = document.getElementById('actividadEditar');
            const status = await fv2.validate();
            $("#contenido-view").waitMe({
                effect: "win8_linear",
                bg: "rgba(255,255,255,0.9)",
                color: "#000",
                textPos: "vertical",
                fontSize: "250px",
            });
            if (status === 'Valid') {
                const formData = new FormData(document.getElementById('actividadEditar'));

                const eventId = formData.get('actividad_id_edit');
    
                fetch('{{ route('actividades.save') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'),
                    }
                })
                .then(response => {
                    $('#contenido-view').waitMe("hide");
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw errorData;
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Datos editados exitosamente:', data);
                    $('#contenido-view').waitMe("hide");
                    Swal.fire({
                        toast: true,
                        position: "bottom-end",
                        showConfirmButton: false,
                        icon: "success",
                        timer: 3000,
                        title: 'Exito actividad editada !'
                    });
                    const event = calendar.getEventById(eventId);
    
                    fetch('{{ route('actividades.listado') }}')
                        .then(response => response.json())
                        .then(actividadesActualizadas => {
                            // Actualiza la variable actividades
                            actividades = actividadesActualizadas;
                            reloadCalendar();
                        })
                        .catch(error => {
                            console.error('Error al recargar las actividades:', error);
                        });
                    if (event) {
                        event.setProp('title', formData.get('titulo_edit'));
                        event.setStart(formData.get('fecha_inicio_edit'));
                        event.setEnd(formData.get('fecha_fin_edit'));
                    }
    
                    const myModalEl = document.getElementById('calendarModalEditar');
                    const modalInstance = bootstrap.Modal.getInstance(myModalEl);
                    modalInstance.hide();
                    form.reset();
                })
                .catch(error => {
                    console.error('Error al guardar los datos:', error);
                    $('#contenido-view').waitMe("hide");
                    Swal.fire({
                        toast: true,
                        position: "bottom-end",
                        showConfirmButton: false,
                        icon: "error",
                        timer: 3000,
                        title: 'Hubo un problema al editar los datos.'
                    });
                });

            }

        });

        async function eliminar() {
            const actividadId = document.getElementById('actividad_id_edit').value; // I

            console.log("Soy la actividad gaaa", actividadId);
            const myModalEl = document.getElementById('calendarModalEditar');
            const modalInstance = bootstrap.Modal.getInstance(myModalEl);
            modalInstance.hide();

            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                customClass: {
                    confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                    cancelButton: "btn btn-label-secondary waves-effect waves-light"
                },
                buttonsStyling: false
            }).then(async (result) => {
                if (result.isConfirmed) {

                    let url = `{{ route('actividades.delete', ':actividadId') }}`;
                    url = url.replace(':actividadId', actividadId);
                    try {
                        const response = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content'),
                            },
                        });

                        const responseData = await response.json();

                        if (responseData.success) {
                            const eventId = actividadId;
                            const event = calendar.getEventById(eventId);
                            if (event) {
                                event.remove();
                            }
                            Swal.fire({
                                toast: true,
                                position: "bottom-end",
                                showConfirmButton: false,
                                icon: "success",
                                timer: 3000,
                                title: responseData.message
                            });
                        } else {
                            Swal.fire({
                                toast: true,
                                position: "bottom-end",
                                showConfirmButton: false,
                                icon: "error",
                                timer: 3000,
                                title: responseData.message
                            });
                        }

                    } catch (error) {
                        console.error('Error al eliminar la actividad:', error);
                        Swal.fire({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            icon: "error",
                            timer: 3000,
                            title: 'Hubo un problema al eliminar la actividad.'
                        });
                    }
                }
            });
        }

        document.getElementById('eliminarActividad').addEventListener('click', eliminar);
    </script>
@endsection
