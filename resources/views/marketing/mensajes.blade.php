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
                Nuevo ticket</button>
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
                            <input type="hidden" id="ticketId" name="ticketId">

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="pregunta">Titulo :</label>
                                    <input type="text" name="titulo" id="titulo" class="form-control" value=""
                                        required="required" pattern="" title="">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="pregunta">Descripción :</label>
                                    <textarea name="descripcion" id="descripcion" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="pregunta">Fecha inicio :</label>
                                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="pregunta">Fecha inicio :</label>
                                    <input type="file" class="form-control" id="adjunto" name="adjunto"
                                        accept="image/*">
                                </div>
                            </div>
                            <div id="vista-previa" style="display: none;">
                                <img id="imagen-previa" src="" alt="Vista previa"
                                    style="max-width: 100%; max-height: 200px; margin-top: 10px;" />
                            </div>

                            <hr>


                            <div class="row mb-4" id="cols-questions">
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-end" id="divSaveEncuesta">
                                    <button type="submit" class="btn btn-primary mt-4" id="savePregunta">Guardar</button>
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
     
    </script>
@endsection
