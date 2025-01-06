@extends('template.template')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/waitMe.css') }}" />

@endsection
@section('content')
    <div class="card">

        <div class="card-header border-bottom">
            <h5 class="card-tittle mb-0">Usuarios</h5>
        </div>

        <div class="card-datatable table-responsive">
            <table class="table" id="tableUsuarios">
                <thead class="border-top">
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Nro. Doc</th>
                        <th>Telefono</th>
                        <th>Dirección</th>
                        <th>Correo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- Modal Crear -->
        <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserModalLabel">Agregar usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5 class="text-muted">Datos de usuario </h5>
                        <form id="usuarioForm" novalidate>
                            <div class="row mb-3">
                                <div class="col-md-6 col-sm-12">
                                    <label for="firstName" class="form-label">Nombres </label>
                                    <input type="text" class="form-control" id="nombres" name="nombres"
                                        placeholder="Nombres" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="lastName" class="form-label">Apellidos </label>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos"
                                        placeholder="Apellidos" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6 col-sm-12">
                                    <label for="status" class="form-label">Tipo de Documento </label>
                                    <select class="form-select" id="tipo_documento" name="tipo_documento" required>
                                        <option value="">Selecciona el tipo de documento</option>
                                        @foreach ($documentos as $documento)
                                            <option value="{{ $documento->id }}" data-min="{{ $documento->min_size }}"
                                                data-max="{{ $documento->max_size }}"
                                                data-alphanumeric="{{ $documento->alphanumeric }}">{{ $documento->name }}
                                                ({{ $documento->short_name }})
                                            </option>
                                        @endforeach


                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <label for="country" class="form-label">Número de Documento </label>
                                    <input type="number" class="form-control" id="documento" name="documento"
                                        placeholder="" required>
                                </div>
                            </div>

                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <label for="taxId" class="form-label">Correo </label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="ejemplo@gmail.com" required>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <label for="username" class="form-label">Telefono </label>
                                    <input type="text" class="form-control" id="telefono" name="telefono"
                                        placeholder="9999999" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12 col-sm-12">
                                    <label for="direccion" class="form-label">Dirección </label>
                                    <input type="text" class="form-control" id="direccion" name="direccion"
                                        placeholder="Dirección" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                @if (auth()->user()->hasRole('superadministrador') || auth()->user()->hasRole('administrador'))
                                    <div class="col-md-12 col-sm-12">
                                        <label for="direccion" class="form-label">Tipo usuario</label>
                                        <select class="form-select" id="rol_usuario" name="rol_usuario" required>
                                            <option value="">Selecciona tipo de usuario</option>
                                            @foreach ($roles as $rol)
                                                <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                            </div>

                            <div class="d-flex justify-content-end mt-2">
                                <button type="button" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary" id="guardarUsuario">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar -->
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="createUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserModalLabel">Editar usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5 class="text-muted">Datos de usuario </h5>
                        <form id="usuarioEditForm" novalidate>

                            <div class="row mb-3">
                                <input type="text" id="id_edit" name="id_edit" value="" class="d-none">
                                <div class="col-md-6 col-sm-12">
                                    <label for="firstName" class="form-label">Nombres </label>
                                    <input type="text" class="form-control" id="nombres_edit" name="nombres_edit"
                                        placeholder="Nombres">
                                </div>
                                <div class="col-md-6">
                                    <label for="lastName" class="form-label">Apellidos </label>
                                    <input type="text" class="form-control" id="apellidos_edit" name="apellidos_edit"
                                        placeholder="Apellidos">
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-md-6 col-sm-12">
                                    <label for="tipo_documento_edit" class="form-label">Tipo de Documento</label>
                                    <select class="form-select" id="tipo_documento_edit" name="tipo_documento_edit"
                                        required>
                                        <option value="">Selecciona el tipo de documento</option>
                                        @foreach ($documentos as $documento)
                                            <option value="{{ $documento->id }}" data-min="{{ $documento->min_size }}"
                                                data-max="{{ $documento->max_size }}"
                                                data-alphanumeric="{{ $documento->alphanumeric }}">{{ $documento->name }}
                                                ({{ $documento->short_name }})
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <label for="documento_edit" class="form-label">Número de Documento</label>
                                    <input type="number" class="form-control" id="documento_edit" name="documento_edit"
                                        placeholder="">
                                </div>
                            </div>


                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <label for="taxId" class="form-label">Correo </label>
                                    <input type="text" class="form-control" id="email_edit" name="email_edit"
                                        placeholder="ejemplo@gmail.com">
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <label for="username" class="form-label">Telefono </label>
                                    <input type="text" class="form-control" id="telefono_edit" name="telefono_edit"
                                        placeholder="9999999">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12 col-sm-12">
                                    <label for="direccion" class="form-label">Dirección </label>
                                    <input type="text" class="form-control" id="direccion_edit" name="direccion_edit"
                                        placeholder="Dirección">
                                </div>
                            </div>

                            <div class="row mb-3">
                                @if(auth()->user()->hasRole('superadministrador') || auth()->user()->hasRole('administrador'))
                                <div class="col-md-6 col-sm-12">
                                    <label for="direccion" class="form-label">Tipo usuario</label>
                                    <select class="form-select" id="rol_edit_usuario" name="rol_edit_usuario" required>
                                        <option value="">Selecciona tipo de usuario</option>
                                        @foreach ($roles as $rol)
                                            <option value="{{ $rol->id }}"
                                            @selected(isset($usuario) && $usuario->roles->contains('id', $rol->id))>
                                                {{ $rol->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                                <div class="col-md-6 col-sm-12">
                                    <label for="taxId" class="form-label">Estado</label>
                                    <select name="estado_edit" id="estado_edit" class="form-select">
                                        <option value="1">Activo</option>
                                        <option value="2">Inactivo</option>

                                    </select>
                                </div>

                            </div>

                            <div class="d-flex justify-content-end mt-2">
                                <button type="button" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary" id="editarUsuario">Guardar</button>
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
    <script src="{{ asset('js/waitMe.js') }}"></script>

@endsection

@section('implemetenciones')
    <script>
        const rangePago = document.querySelector('#rangePago');
        document.addEventListener('DOMContentLoaded', function() {
            let table = new DataTable('#tableUsuarios', {
                // Configuración de DataTable

                ajax: {
                    url: "{{ role_route('usuarios.list') }}",
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
                        data: 'name'
                    },
                    {
                        data: 'last_name'
                    },
                    {
                        data: 'document_number'
                    },
                    {
                        data: 'telefono'
                    },
                    {
                        data: 'direccion'
                    },
                    {
                        data: 'email'
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
                                `;
                        }
                    }
                ],
                buttons: [{
                    text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Nuevo Usuario</span>',
                    className: "add-new btn btn-primary ms-2 ms-sm-0 waves-effect waves-light",
                    action: function() {
                        $("#id").val(0);
                        $("#divDatosPagos").find('input, select').each(function() {
                            $(this).attr('required', 'required');
                            const fieldName = $(this).attr('name');
                            fv.addField(fieldName);
                        });
                        $("#createUserModal").modal('show');
                    }
                }],
                processing: true,
                error: function(xhr, error, thrown) {
                    console.error('Error en la carga de datos:', error, thrown);
                }
            });

            const loginButton = document.getElementById('guardarUsuario');
            const form = document.getElementById('usuarioForm');


            const fv = FormValidation.formValidation(
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


            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevenir el envío predeterminado del formulario
                $("#contenido-view").waitMe({
                    effect: "win8_linear",
                    bg: "rgba(255,255,255,0.9)",
                    color: "#000",
                    textPos: "vertical",
                    fontSize: "250px",
                });
                fv.validate().then(function(status) {
                    if (status === 'Valid') {
                        const formData = new FormData(form);
                        // Enviar los datos mediante fetch
                        fetch("{{ role_route('usuarios.save') }}", {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content'),
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    // Si la respuesta no es 200-299, lanza un error personalizado
                                    return response.json().then(errorData => {
                                        throw errorData;
                                    });
                                }
                                return response.json();
                            })
                            .then(data => {
                                // Maneja la respuesta exitosa
                                $('#contenido-view').waitMe("hide");
                                console.log('Datos guardados exitosamente:', data);
                                Swal.fire({
                                    toast: true,
                                    position: "bottom-end",
                                    showConfirmButton: false,
                                    icon: "success",
                                    timer: 3000,
                                    title: 'Exito usuario creado !'
                                });
                                $("#createUserModal").modal('hide');
                                table.ajax
                            .reload(); // Recargar tabla u otros elementos dinámicos
                            })
                            .catch(error => {
                                // Verifica si el error tiene un mensaje y lo muestra
                                $('#contenido-view').waitMe("hide");
                                Swal.fire({
                                    toast: true,
                                    position: "bottom-end",
                                    showConfirmButton: false,
                                    icon: "error",
                                    timer: 3000,
                                    title: 'Hubo un problema al crear el usuario.'
                                });
                                if (error.message) {
                                    Swal.fire({
                                        toast: true,
                                        position: "bottom-end",
                                        showConfirmButton: false,
                                        icon: "error",
                                        timer: 3000,
                                        title: error.message
                                    });
                                } else {
                                    Swal.fire({
                                        toast: true,
                                        position: "bottom-end",
                                        showConfirmButton: false,
                                        icon: "error",
                                        timer: 3000,
                                        title: 'Error al crear el usuario, intentelo nuevamente'
                                    });
                                }


                            });

                    }
                });
            });

            // EDITAR USUARIO
            const formEditarUsuario = document.getElementById('usuarioEditForm');

            formEditarUsuario.addEventListener('submit', function(e) {
                e.preventDefault();
                $("#contenido-view").waitMe({
                effect: "win8_linear",
                bg: "rgba(255,255,255,0.9)",
                color: "#000",
                textPos: "vertical",
                fontSize: "250px",
            });
                const formData = new FormData(formEditarUsuario);
                fetch("{{ role_route('usuarios.save') }}", {
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
                        $('#contenido-view').waitMe("hide");
                        $("#editUserModal").modal('hide');
                        Swal.fire({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            icon: "success",
                            timer: 3000,
                            title: 'Exito usuario editado !'
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
                                title: 'Hubo un problema al editar los datos.'
                            });
                        } else {
                            Swal.fire({
                                toast: true,
                                position: "bottom-end",
                                showConfirmButton: false,
                                icon: "error",
                                timer: 3000,
                                title: 'Hubo un problema al editar los datos.'
                            });
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
                        }
                    });
            });

            $('#createUserModal').on('hidden.bs.modal', function() {
                document.getElementById('usuarioForm').reset();
                fv.resetForm();

            });

        });

        function editar(id) {

            let url = `{{ role_route('usuarios.edit', ':id') }}`;
            url = url.replace(':id', id);

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    console.log("hola soy la data", data);

                    $("#id_edit").val(data.usuario.id);
                    $("#nombres_edit").val(data.usuario.name);
                    $("#apellidos_edit").val(data.usuario.last_name);
                    $("#tipo_documento_edit").val(data.usuario.document_id);
                    $("#documento_edit").val(data.usuario.document_number);
                    $("#email_edit").val(data.usuario.email);
                    $("#telefono_edit").val(data.usuario.telefono);
                    $("#direccion_edit").val(data.usuario.direccion);
                    $("#estado_edit").val(data.usuario.status);

                    const rolId = data.usuario.roles.length > 0 ? data.usuario.roles[0].id :
                    null; // Obtener el primer rol
                    $("#rol_edit_usuario").val(rolId); // Establecer el valor en el select

                    if (data.password) {
                        $("#contrasena").val('****');
                    }

                    // Mostrar el modal de edición de usuario
                    $("#editUserModal").modal('show');
                })
                .catch(error => {
                    console.error('Error al obtener los datos del usuario:', error);
                    alert('Ocurrió un error al obtener los datos del usuario.');
                });
        }
        
    </script>
@endsection
