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
                Nuevo archivo</button>
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
                        <h5 class="modal-title" id="encuestaModalLabel" style="text-transform: uppercase">Archivo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="documentoForm" novalidate>
                        <div class="modal-body">
                            <input type="hidden" name="documento_id" id="documento_id" value="">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="text-light fw-medium">Datos del Archivo</h5>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre del Archivo</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="mb-3">
                                        <label for="tipo" class="form-label">Tipo</label>
                                        <select class="form-select" name="tipo" id="tipo" required>
                                            <option value="">Seleccionar</option>
                                            <option value="1">Archivo General</option>
                                            <option value="2">Archivo con Vencimiento</option>
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

       

    </script>

@endsection
