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
            <button class="btn btn-primary" id="new-survey-btn" data-bs-toggle="modal" data-bs-target="#ticketsModal">+
                Nueva cotización</button>
        </div>

        <div class="card-body">
            <table class="table" id="tablaPreguntas">
                <thead class="border-top">
                    <tr>
                        <th>Titulo</th>
                        <th>Descrioción</th>
                        <th>Fecha Creación</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="modal fade" id="ticketsModal" tabindex="-1" aria-labelledby="encuestaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="encuestaModalLabel" style="text-transform: uppercase">Ticket</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="preguntasForm" novalidate>
                            <div class="col-12">
                                <h5 class="text-light fw-medium">Datos del Archivo</h5>
                            </div>
                            <div class="row mb-4">
                                <h5 class="mb-3">Datos del Cliente</h5>
                                <div class="col-md-12 col-sm-12 mb-3">
                                    <label for="clienteNombre" class="form-label">Nombre del Cliente</label>
                                    <input type="text" class="form-control" id="clienteNombre"
                                        placeholder="Ingresa el nombre del cliente" required>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <label for="clienteEmail" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="clienteEmail"
                                        placeholder="correo@ejemplo.com" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="clienteTelefono" class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" id="clienteTelefono"
                                        placeholder="Ingresa el número de teléfono" required>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <h5 class="mb-3">Información del Proyecto</h5>
                                <div class="col-md-6 mb-3">
                                    <label for="proyectoNombre" class="form-label">Nombre del Proyecto</label>
                                    <input type="text" class="form-control" id="proyectoNombre"
                                        placeholder="Ingresa el nombre del proyecto" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="proyectoUbicacion" class="form-label">Ubicación del Proyecto</label>
                                    <input type="text" class="form-control" id="proyectoUbicacion"
                                        placeholder="Ingresa la ubicación del proyecto">
                                </div>
                                <div class="col-12">
                                    <label for="proyectoDescripcion" class="form-label">Descripción del Proyecto</label>
                                    <textarea class="form-control" id="proyectoDescripcion" rows="3" placeholder="Describe el proyecto"></textarea>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <h5 class="mb-3">Detalles de Cotización</h5>
                                <div class="col-md-6 mb-3">
                                    <label for="costoManoObra" class="form-label">Costo de Mano de Obra (S/)</label>
                                    <input type="number" class="form-control" id="costoManoObra"
                                        placeholder="Ingresa el costo de mano de obra" step="0.01">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="costoMateriales" class="form-label">Costo de Materiales (S/)</label>
                                    <input type="number" class="form-control" id="costoMateriales"
                                        placeholder="Ingresa el costo de materiales" step="0.01">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="costoEquipos" class="form-label">Costo de Equipos (S/)</label>
                                    <input type="number" class="form-control" id="costoEquipos"
                                        placeholder="Ingresa el costo de equipos" step="0.01">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="otrosCostos" class="form-label">Otros Costos (S/)</label>
                                    <input type="number" class="form-control" id="otrosCostos"
                                        placeholder="Ingresa otros costos adicionales" step="0.01">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <h5 class="mb-3">Comentarios Adicionales</h5>
                                <div class="col-12">
                                    <textarea class="form-control" id="comentariosAdicionales" rows="4"
                                        placeholder="Ingresa comentarios adicionales"></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-end" id="divSaveEncuesta">
                                    <button type="submit" class="btn btn-primary mt-4"
                                        id="savePregunta">Guardar</button>
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
        const formGuardarPregunta = document.getElementById('preguntasForm');
        let modalPreguntas = document.getElementById('ticketsModal');
        let table;
        let fv;

        document.addEventListener('DOMContentLoaded', () => {



        });


        fv = FormValidation.formValidation(
            formGuardarPregunta, {
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
    </script>
@endsection
