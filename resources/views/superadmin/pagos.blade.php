@extends('template.template')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/waitMe.css') }}" />
@endsection
@section('content')
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-tittle mb-0">Pagos</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="table" id="tablePagos">
                <thead class="border-top">
                  <tr>
                    <th>Empresa</th>
                    <th>Realizado por</th>
                    <th>Fecha de pago</th>
                    <th>Periodo</th>
                    <th>Estado</th>
                    <th>Acciónes</th>
                  </tr>
                </thead>
              </table>
        </div>
    </div>

    <div class="modal fade" id="modalPago" tabindex="-1" aria-labelledby="modalPagoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalPagoLabel">Pago</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="pagoForm"  novalidate>
              <div class="modal-body">
                <input type="hidden" name="pago_id" id="pago_id" value="" >
                <div class="row">
                    <div class="col-12">
                        <h5 class="text-light fw-medium">Datos de la empresa</h5>
                    </div>
                    <div class="col-12" id="divSelectEmpresa">
                        <div class="mb-3">
                            <label for="empresaID" class="form-label">Nombre de la Empresa</label>
                            <select class="form-select" name="empresaID" id="selectEmpresa" required></select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="empresa_tipo_documento" class="form-label">Tipo de Documento</label>
                            <select class="form-select" id="empresa_tipo_documento" disabled>
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
                            <input type="text" class="form-control" id="empresa_documento" disabled>
                          </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="empresa_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="empresa_email" disabled>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="empresa_telefono" class="form-label">Teléfono</label>
                            <input type="number" class="form-control" id="empresa_telefono" disabled>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="empresa_direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="empresa_direccion" disabled>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <h5 class="text-light fw-medium">Datos de pago</h5>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="mb-3">
                            <label for="rangePago" class="form-label">Período</label>
                            <input type="text" class="form-control" placeholder="d-m-YYYY a d-m-YYYY" id="rangePago" name="rangePago" required disabled/>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="mb-3">
                            <label for="monto" class="form-label">Monto</label>
                            <input type="text" class="form-control" id="monto" name="monto" required disabled>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="1">Pagado</option>
                                <option value="2">Pendiente</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12"><h5 class="text-light fw-medium">Datos del administrador</h5></div>
                    <div class="col-12" id="divSelectAdministrador">
                        <label for="administrador_id" class="form-label">Nombres y apellidos</label>
                        <select class="form-select" name="administrador_id" id="selectAdministrador" required></select>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="administrador_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="administrador_email" disabled>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="administrador_telefono" class="form-label">Teléfono</label>
                            <input type="number" class="form-control" id="administrador_telefono" disabled>
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveButton">Guardar</button>
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
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="{{ asset('js/waitMe.js') }}"></script>

@endsection

@section('implemetenciones')
    <script>
        const rangePago = document.querySelector('#rangePago');
        const saveButton = document.getElementById('saveButton');

        const fv = FormValidation.formValidation(
            document.getElementById('pagoForm'),
            {
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
        const spanishTranslation = FormValidation.locales.es_ES;
        fv.setLocale('es_ES', spanishTranslation);

        const table = new DataTable('#tablePagos', {
            ajax: {
                url: "{{ role_route('pagos.list') }}",
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
                { data: 'empresa.nombre' },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `${row.cliente.name} ${row.cliente.last_name}`;
                    }
                },
                { data: 'fecha_pago' },
                {
                    data: 'null',
                    render: function(data, type, row) {
                        return `${row.fecha_inicio + ' - '+ row.fecha_fin}`;
                    }
                },
                {
                    data: 'status',
                    render: function(data) {
                        // Cambia el texto del badge según el estado
                        switch (data) {
                            case 1:
                                return `<span class="badge bg-label-success" text-capitalized>Pagado</span>`;
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
                        return `
                            <button class="btn btn-sm btn-text-warning rounded-pill btn-icon" onclick="editar(${row.id})" title="Editar">
                                <i class="ti ti-pencil ti-md"></i>
                            </button>
                            <button class="btn btn-sm btn-text-danger rounded-pill btn-icon d-none" onclick="eliminar(${row.id})" title="Eliminar">
                                <i class="ti ti-trash ti-md"></i>
                            </button>
                        `;
                    }
                }
            ],
            buttons: [
                {
                    text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Nuevo Pago</span>',
                    className: "add-new btn btn-primary ms-2 ms-sm-0 waves-effect waves-light",
                    action: function() {
                        // Limpiar el valor seleccionado
                        $('#selectEmpresa').val(null).trigger('change');
                        // Mostrar el modal para el nuevo pago
                        $("#modalPago").modal('show');
                    }
                }
            ],
            processing: true,
            error: function(xhr, error, thrown) {
                console.error('Error en la carga de datos:', error, thrown);
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
        });
        $('#selectEmpresa').select2({
            minimumInputLength: 3,
            dropdownParent: $('#modalPago'),
            ajax: {
                url: '{{ role_route("pagos.dataEmpresa") }}',
                data: function (params) {
                    return { search: params.term };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.nombre + " [" + item.document_number + "]",
                                id: item.id,
                                document_type: item.document_id,
                                document: item.document_number,
                                email: item.email,
                                phone: item.telefono,
                                address: item.direccion
                            };
                        })
                    };
                }
            }
        });

        saveButton.addEventListener('click', async function() {
            const status = await fv.validate();
            $("#contenido-view").waitMe({
                effect: "win8_linear",
                bg: "rgba(255,255,255,0.9)",
                color: "#000",
                textPos: "vertical",
                fontSize: "250px",
            });
            if (status === 'Valid') {
                let formData = new FormData(document.getElementById('pagoForm'));
                formData.append('pago_id', $("#pago_id").val());
                formData.append('empresaID', $("#selectEmpresa").val());
                formData.append('rangePago', $("#rangePago").val());
                formData.append('monto', $("#monto").val());
                formData.append('status', $("#status").val());
                formData.append('administrador_id', $("#selectAdministrador").val());

                try {
                    const response = await fetch('{{ role_route("pagos.save") }}', {
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
                        $("#modalPago").modal('hide');
                        Swal.fire({
                            toast:true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            icon: "success",
                            timer: 3000,
                            title: responseData.message
                        });
                        document.getElementById('pagoForm').reset();
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
        $('#selectEmpresa').on('select2:select', function (e) {
            fv.validate();
            if (this.value !== '') {
                const empresaData = $(this).select2('data')[0];
                actualizarDatosFormulario(empresaData, 'empresa');
                cargarAdministradores(this.value);
            }
        });

        $('#selectAdministrador').on('select2:select', function (e) {
            fv.validate();
            if (this.value !== '') {
                const adminData = $(this).select2('data')[0];
                actualizarDatosFormulario(adminData, 'administrador');
            }
        });

        $('#modalPago').on('hidden.bs.modal', function () {
            $("#selectEmpresa,#selectAdministrador").empty();

            $("#pago_id").val("");
            $("#divDatosPagos").find('input, select').each(function() {
                $(this).removeAttr('required disabled');
            });
            $("#selectAdministrador").empty()
            document.getElementById('pagoForm').reset();
            fv.resetForm();
        });

        $('#modalPago').on('shown.bs.modal', function () {
            $("#rangePago, #monto, #status").attr('disabled', 'disabled');
            $("#selectEmpresa,#selectAdministrador").attr('disabled', 'disabled');

            if ($("#pago_id").val() == 0) {
                $("#selectEmpresa,#selectAdministrador").removeAttr('disabled');

                $("#rangePago, #monto, #status").removeAttr('disabled');
                document.getElementById('pagoForm').reset();
                fv.resetForm();
            }

        });

        function editar(id) {
            fetch("{{ role_route('pagos.data', ':id') }}".replace(':id', id))
            .then(response => response.json())
            .then(data => {
                cargarDatosEmpresa(data.empresa);
                cargarDatosPago(data);

                let empresaOption = new Option(
                    `${data.empresa.nombre} [${data.empresa.document_number}]`,
                    data.empresa.id,
                    true,
                    true
                );

                $('#selectEmpresa').append(empresaOption).trigger('change');

                cargarAdministradores(data.empresa.id, data.cliente.id);

                // Mostrar el modal
                $("#modalPago").modal('show');
            })
            .catch(error => {
                console.error('Error al editar la empresa:', error);
                alert('Ocurrió un error al obtener los datos de la empresa.');
            });
        }

        function reloadTable() {
            table.ajax.reload();
        }


        function actualizarDatosFormulario(data, tipo) {
            if (tipo === 'empresa') {
                // Actualizar datos de la empresa
                $("#empresa_tipo_documento").val(data.document_type);
                $("#empresa_documento").val(data.document);
                $("#empresa_email").val(data.email);
                $("#empresa_telefono").val(data.phone);
                $("#empresa_direccion").val(data.address);
            } else if (tipo === 'administrador') {
                // Actualizar datos del administrador
                $("#administrador_id").val(data.id);
                $("#administrador_email").val(data.email);
                $("#administrador_telefono").val(data.phone);
            }
        }

        function cargarDatosEmpresa(empresa) {
            $("#empresa_nombre").val(empresa.nombre);
            $("#empresa_tipo_documento").val(empresa.document_id);
            $("#empresa_documento").val(empresa.document_number);
            $("#empresa_email").val(empresa.email);
            $("#empresa_telefono").val(empresa.telefono);
            $("#empresa_direccion").val(empresa.direccion);
        }

        function cargarAdministradores(empresaId, selectedAdministradorId = null) {
            fetch("{{ role_route('pagos.dataUser', ':id') }}".replace(':id', empresaId))
                .then(response => response.json())
                .then(usersData => {
                    const results = $.map(usersData, function(item) {
                        return {
                            text: item.name + " " + item.last_name + " [" + item.document_number + "]",
                            id: item.id,
                            email: item.email,
                            phone: item.telefono
                        };
                    });

                    // Limpiar el select2 del administrador antes de actualizar
                    $("#selectAdministrador").empty().select2({
                        data: results,
                        dropdownParent: $('#modalPago'),
                        placeholder: "Seleccione un administrador",
                        allowClear: true
                    }).val(null).trigger('change');;

                    // Seleccionar el administrador correspondiente si se proporciona uno
                    if (selectedAdministradorId) {
                        $("#selectAdministrador").val(selectedAdministradorId).trigger('change');
                        const adminData = $("#selectAdministrador").select2('data')[0];
                        actualizarDatosFormulario(adminData, 'administrador');
                        fv.validate();
                    }

                    // Agregar el manejador de evento después de configurar el select2
                    $('#selectAdministrador').off('select2:select').on('select2:select', function(e) {
                        fv.validate();
                        if (this.value !== '') {
                            const adminData = $(this).select2('data')[0];
                            actualizarDatosFormulario(adminData, 'administrador');
                        }
                    });
                })
                .catch(error => {
                    console.error('Error al obtener los administradores:', error);
                    alert('Ocurrió un error al obtener los datos del administrador.');
                });
        }

        function cargarDatosPago(data) {
            $("#pago_id").val(data.id);
            rangePago._flatpickr.setDate([data.fecha_inicio, data.fecha_fin]);
            $("#monto").val(data.monto);
            $("#status").val(data.status);
            $("#status").removeAttr('disabled');
            if (data.status == 1) {
                $("#status").attr('disabled', 'disabled');
            }
        }

    </script>
@endsection
