@extends('template.template')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('css/waitMe.css') }}" />


@endsection
@section('content')
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-tittle mb-0">Empresas</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="table" id="tableEmpresas">
                <thead class="border-top">
                  <tr>
                    <th>Empresa</th>
                    <th>Documento</th>
                    <th>Responsable</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th>Bloquear</th>
                    <th>Estado</th>
                    <th>Acciónes</th>
                  </tr>
                </thead>
              </table>
        </div>
    </div>

    <div class="modal fade" id="modalEmpresa" tabindex="-1" aria-labelledby="modalEmpresaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalEmpresaLabel">Crear/Editar Empresa</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="empresaForm"  novalidate>
              <div class="modal-body">
                <input type="hidden" name="empresa_id" id="empresa_id" value="0">
                <div class="row">
                    <div class="col-12">
                        <h5 class="text-light fw-medium">Datos de la empresa</h5>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="empresa_nombre" class="form-label">Nombre de la Empresa</label>
                            <input type="text" class="form-control" id="empresa_nombre" name="empresa_nombre" placeholder="Ingresa el nombre de la empresa" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="empresa_tipo_documento" class="form-label">Tipo de Documento</label>
                            <select class="form-select" id="empresa_tipo_documento" name="empresa_tipo_documento" required>
                              <option value="">Selecciona el tipo de documento</option>
                              @foreach ($documentos as $documento)
                                  <option value="{{$documento->id}}" data-min="{{$documento->min_size}}" data-max="{{$documento->max_size}}" data-alphanumeric="{{$documento->alphanumeric}}">{{$documento->name}} ({{$documento->short_name}})</option>
                              @endforeach
                            </select>
                          </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="empresa_documento" class="form-label">Número de Documento</label>
                            <input type="text" class="form-control" id="empresa_documento" name="empresa_documento" placeholder="Ingresa el número de documento" required>
                          </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="empresa_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="empresa_email" name="empresa_email" placeholder="Ingresa el email" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="empresa_telefono" class="form-label">Teléfono</label>
                            <input type="number" class="form-control" id="empresa_telefono" name="empresa_telefono" placeholder="Ingresa el teléfono" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="empresa_direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="empresa_direccion" name="empresa_direccion" placeholder="Ingresa la dirección" required>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row" id="divDatosPagos">
                    <div class="col-12">
                        <h5 class="text-light fw-medium">Datos de pago</h5>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="mb-3">
                            <label for="rangePago" class="form-label">Período</label>
                            <input type="text" class="form-control" placeholder="d-m-YYYY a d-m-YYYY" id="rangePago" name="rangePago"/>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="mb-3">
                            <label for="monto" class="form-label">Monto</label>
                            <input type="text" class="form-control" id="monto" name="monto" placeholder="Ingresa la dirección">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Seleccionar</option>
                                <option value="2">Pendiente</option>
                                <option value="1">Pagado</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12"><h5 class="text-light fw-medium">Datos del administrador</h5></div>
                    <input type="hidden" id="administrador_id" name="administrador_id" value="0">
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="administrador_nombres" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="administrador_nombres" name="administrador_nombres" placeholder="Ingresa nombres" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="administrador_apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="administrador_apellidos" name="administrador_apellidos" placeholder="Ingresa apellidos" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="administrador_tipo_documento" class="form-label">Tipo de Documento</label>
                            <select class="form-select" id="administrador_tipo_documento" name="administrador_tipo_documento" required>
                              <option value="">Selecciona el tipo de documento</option>
                              @foreach ($documentos as $documento)
                                  <option value="{{$documento->id}}" data-min="{{$documento->min_size}}" data-max="{{$documento->max_size}}" data-alphanumeric="{{$documento->alphanumeric}}">{{$documento->name}} ({{$documento->short_name}})</option>
                              @endforeach
                            </select>
                          </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="administrador_documento" class="form-label">Número de Documento</label>
                            <input type="text" class="form-control" id="administrador_documento" name="administrador_documento" placeholder="Ingresa el número de documento" required>
                          </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="administrador_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="administrador_email" name="administrador_email" placeholder="Ingresa el email" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="administrador_telefono" class="form-label">Teléfono</label>
                            <input type="number" class="form-control" id="administrador_telefono" name="administrador_telefono" placeholder="Ingresa el teléfono" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="administrador_direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="administrador_direccion" name="administrador_direccion" placeholder="Ingresa la dirección" required>
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="loginButton">Guardar</button>

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              </div>
            </form>
          </div>
        </div>
    </div>
@endsection
@section('scripts')

    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/waitMe.js') }}"></script>


@endsection

@section('implemetenciones')
    <script>
        const rangePago = document.querySelector('#rangePago');
        const loginButton = document.getElementById('loginButton');

        const fv = FormValidation.formValidation(
            document.getElementById('empresaForm'),
            {
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
        const spanishTranslation = FormValidation.locales.es_ES;
        fv.setLocale('es_ES', spanishTranslation);

        const table = new DataTable('#tableEmpresas', {
            ajax: {
                url: "{{ route('empresas.list') }}",
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
            columns: [
                { data: 'nombre' },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `${row.documento.short_name}: ${row.document_number}`;
                    }
                },
                { data: 'usuario.name' },
                { data: 'usuario.email' },
                { data: 'telefono' },
                {
                    data: 'null',
                    render: function(data, type, row) {
                        return `
                            <label class="switch">
                                <input type="checkbox" class="switch-input bloquearEmpresa" data-empresaID="${row.id}" ${ row.status == 2 ? 'checked' : ''}/>
                                <span class="switch-toggle-slider">
                                    <span class="switch-on">SI</span>
                                    <span class="switch-off">NO</span>
                                </span>
                            </label>
                        `;
                    }
                },
                {
                    data: 'status',
                    render: function(data) {
                        // Cambia el texto del badge según el estado
                        switch (data) {
                            case 1:
                                return `<span class="badge bg-label-success" text-capitalized>Activo</span>`;
                            case 2:
                                return `<span class="badge bg-label-warning" text-capitalized>Bloqueado</span>`;
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
                            <button class="btn btn-sm btn-text-danger rounded-pill btn-icon" onclick="eliminar(${row.id})" title="Eliminar">
                                <i class="ti ti-trash ti-md"></i>
                            </button>
                        `;
                    }
                }
            ],
            buttons: [
                {
                    text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Nueva Empresa</span>',
                    className: "add-new btn btn-primary ms-2 ms-sm-0 waves-effect waves-light",
                    action: function() {
                        $("#empresa_id").val(0);
                        $("#divDatosPagos").find('input, select').each(function() {
                            $(this).attr('required', 'required');
                            const fieldName = $(this).attr('name');
                            fv.addField(fieldName);
                        });
                        $("#modalEmpresa").modal('show');
                    }
                }
            ],
            processing: true,
            error: function(xhr, error, thrown) {
                console.error('Error en la carga de datos:', error, thrown);
            },
            drawCallback: function () {
                initBloquearEmpresa();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            if (typeof rangePago != undefined) {
                rangePago.flatpickr({
                    mode: 'range',
                    dateFormat: 'd/m/Y',
                    locale: 'es'
                });
            }

            $("#empresa_tipo_documento, #administrador_tipo_documento").on('change', function() {
                if($(this).val()!=''){
                    let targetField = ($(this).attr('id') === 'empresa_tipo_documento') ? $("#empresa_documento") : $("#administrador_documento");

                    let selectedOption = $(this).find('option:selected');
                    if (targetField) {
                        const fieldName = targetField.attr('name');
                        fv.removeField(fieldName);

                        let minSize = selectedOption.data('min');
                        let maxSize = selectedOption.data('max');
                        let isAlphanumeric = selectedOption.data('alphanumeric');

                        targetField.attr('maxlength', maxSize).attr('minlength', minSize);
                        fv.addField(fieldName, {
                            validators: {
                                stringLength: {
                                    min: minSize,
                                    max: maxSize,
                                    message: `El documento debe tener entre ${minSize} y ${maxSize} caracteres`
                                },
                                regexp: {
                                    regexp: isAlphanumeric ? /^[a-zA-Z0-9]+$/ : /^\d+$/,
                                    message: isAlphanumeric ? 'El documento debe ser alfanumérico' : 'El documento debe ser numérico'
                                }
                            }
                        });
                    }
                }
            });
        });


        loginButton.addEventListener('click', async function() {
            const status = await fv.validate();
            $("#contenido-view").waitMe({
                effect: "win8_linear",
                bg: "rgba(255,255,255,0.9)",
                color: "#000",
                textPos: "vertical",
                fontSize: "250px",
            });
            if (status === 'Valid') {
                const formData = new FormData(document.getElementById('empresaForm'));

                try {
                    const response = await fetch('{{ route("empresas.save") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }
                    });

                    const responseData = await response.json();

                    if (responseData.success) {
                        reloadTable();
                        $('#contenido-view').waitMe("hide");
                        $("#modalEmpresa").modal('hide');
                        Swal.fire({
                            toast:true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            icon: "success",
                            timer: 3000,
                            title: responseData.message
                        });
                        document.getElementById('empresaForm').reset();
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
            }
        });


        $('#modalEmpresa').on('hidden.bs.modal', function () {
            $("#divDatosPagos").find('input, select').each(function() {
                $(this).removeAttr('required'); // Quitar el required
                $(this).removeAttr('disabled');
            });
            document.getElementById('empresaForm').reset();
            fv.resetForm();
        });
        
        $('#modalEmpresa').on('shown.bs.modal', function () {
            if($("#empresa_id").val()==0){
                document.getElementById('empresaForm').reset();
                fv.resetForm();
            }
            $("#empresa_tipo_documento").trigger('change');
            $("#administrador_tipo_documento").trigger('change');
        });
        
        async function initBloquearEmpresa() {
            const checkboxes = document.querySelectorAll('.bloquearEmpresa');

            for (const checkbox of checkboxes) {
                checkbox.addEventListener('change', async function () {
                    const isChecked = this.checked;
                    const empresaID = this.dataset.empresaid;

                    const result = await Swal.fire({
                        title: isChecked ? '¿Estás seguro de bloquear a esta empresa?' : '¿Estás seguro de desbloquear a esta empresa?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Sí',
                        customClass: {
                            confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                            cancelButton: "btn btn-label-secondary waves-effect waves-light"
                        },
                        buttonsStyling: false
                    });

                    if (result.isConfirmed) {
                        try {
                            const response = await fetch('{{ route("empresas.activate") }}', {
                                method: 'POST',
                                body: JSON.stringify({
                                    id: empresaID,
                                    checked: isChecked ? 1 : 0
                                }),
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }
                            });

                            const responseData = await response.json();

                            if (responseData.success) {
                                reloadTable();
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
                            Swal.fire({
                                toast: true,
                                position: "bottom-end",
                                showConfirmButton: false,
                                icon: "error",
                                timer: 3000,
                                title: 'Error en la solicitud'
                            });
                        }
                    } else {
                        // Revertir el estado del checkbox si el usuario cancela
                        this.checked = !isChecked;
                    }
                });
            }
        }

        function editar(id) {
            fetch("{{ route('empresas.data', ':id') }}".replace(':id', id))
            .then(response => response.json())
            .then(data => {
                console.log(data);
                // EMPRESA
                $("#empresa_id").val(data.id);
                $("#empresa_nombre").val(data.nombre);
                $("#empresa_tipo_documento").val(data.document_id);
                $("#empresa_documento").val(data.document_number);
                $("#empresa_email").val(data.email);
                $("#empresa_telefono").val(data.telefono);
                $("#empresa_direccion").val(data.direccion);

                // PAGOS

                const fechaInicio = moment(data.ultimo_pago.fecha_inicio).format('DD/MM/YYYY');
                const fechaFin = moment(data.ultimo_pago.fecha_fin).format('DD/MM/YYYY');
                rangePago._flatpickr.setDate([fechaInicio, fechaFin]);

                $("#monto").val(data.ultimo_pago.monto);
                $("#status").val(data.ultimo_pago.status);

                // USUARIO

                $("#administrador_id").val(data.usuario.id);
                $("#administrador_nombres").val(data.usuario.name);
                $("#administrador_apellidos").val(data.usuario.last_name);
                $("#administrador_tipo_documento").val(data.usuario.document_id);
                $("#administrador_documento").val(data.usuario.document_number);
                $("#administrador_email").val(data.usuario.email);
                $("#administrador_telefono").val(data.usuario.telefono);
                $("#administrador_direccion").val(data.usuario.direccion);

                $("#divDatosPagos").find('input, select').each(function() {
                    $(this).removeAttr('required'); // Quitar el required
                    $(this).attr('disabled','disabled');
                    const fieldName = $(this).attr('name');
                });

                $("#modalEmpresa").modal('show');
            })
            .catch(error => {
                console.error('Error al editar la empresa:', error);
                alert('Ocurrió un error al obtener los datos de la empresa.');
            });
        }

        async function eliminar(id) {
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
            }).then(async (result) => { // Cambié a async aquí
                if (result.isConfirmed) {
                    // Llamada fetch para eliminar la empresa
                    try {
                        const response = await fetch('{{ route('empresas.delete', ':id') }}'.replace(':id', id), {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json', // Agregado para indicar el tipo de contenido
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            body: JSON.stringify({ id: id }), // Cambiado a JSON
                        });

                        const responseData = await response.json();

                        if (responseData.success) {
                            reloadTable();
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
                        console.error('Error al eliminar la empresa:', error);
                        Swal.fire({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            icon: "error",
                            timer: 3000,
                            title: 'Hubo un problema al eliminar la empresa.'
                        });
                    }
                }
            });
        }

        function reloadTable() {
            table.ajax.reload();
        }


    </script>
@endsection
