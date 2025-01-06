@extends('template.template')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/buttons.bootstrap5.css') }}" />
@endsection
@section('content')
    <div class="card">
        <div class="container">
            <div class="card-body">
                <div class="row mb-3">
                    <h5 class="text-light fw-medium">Editar información</h5>
                </div>
                <form id="usuarioEditForm">
                    <div class="row mb-3">

                        <input type="text" id="id_edit" name="id_edit" value="{{ $user->id }}" class="d-none">

                        <div class="col-md-6 col-sm-12">
                            <label for="nombres_edit" class="form-label">Nombres </label>
                            <input type="text" class="form-control" id="nombres_edit" name="nombres_edit"
                                placeholder="Nombres" value="{{ $user->name }}">
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="apellidos_edit" class="form-label">Apellidos </label>
                            <input type="text" class="form-control" id="apellidos_edit" name="apellidos_edit"
                                placeholder="Apellidos" value=" {{ $user->last_name }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 col-sm-12">
                            <label for="tipo_documento_edit" class="form-label">Tipo de Documento</label>
                            <select class="form-select" id="tipo_documento_edit" name="tipo_documento_edit" required>
                                <option value="">Selecciona el tipo de documento</option>
                                @foreach ($documentos as $documento)
                                    <option value="{{ $documento->id }}" data-min="{{ $documento->min_size }}"
                                        data-max="{{ $documento->max_size }}"
                                        data-alphanumeric="{{ $documento->alphanumeric }}"
                                        {{ $user->document_id == $documento->id ? 'selected' : '' }}>
                                        {{ $documento->name }} ({{ $documento->short_name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="documento_edit" class="form-label">Número de documento </label>
                            <input type="text" class="form-control" id="documento_edit" name="documento_edit"
                                placeholder="" value="{{ $user->document_number }}">
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="telefono_edit" class="form-label">Telefono </label>
                            <input type="number" class="form-control" id="telefono_edit" name="telefono_edit"
                                placeholder="9999999" value="{{ $user->telefono }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="email_edit" class="form-label">Correo </label>
                            <input type="email" class="form-control" id="email_edit" name="email_edit"
                                placeholder="ejemplo@gmail.com" value="{{ $user->email }}">
                        </div>
                        <div class="col-md-8">
                            <label for="direccion_edit" class="form-label">Dirección </label>
                            <input type="text" class="form-control" id="direccion_edit" name="direccion_edit"
                                placeholder="Dirección" value="{{ $user->direccion }}">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <button type="submit" class="btn btn-primary" id="buttonUpdate">Editar información</button>
                    </div>
                </form>
            </div>

            <hr>

            <div class="card-body">
                <div class="row mb-3">
                    <h5 class="text-light fw-medium">Cambiar contraseña</h5>
                </div>
                <form id="cambiarContrasenaForm">
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12 mb-6 form-password-toggle">
                            <label class="form-label" for="password">Nueva contraseña</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    required>
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-6 form-password-toggle">
                            <label class="form-label" for="password_confirm">Confirmar nueva contraseña</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password_confirm" class="form-control"
                                    name="password_confirm"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    required>
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <button type="submit" class="btn btn-primary" id="buttonChangePassword">Cambiar
                            contraseña</button>
                    </div>
                </form>
            </div>


        </div>

    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/datatables-bootstrap5.js') }}"></script>
@endsection

@section('implemetenciones')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // EDITAR USUARIO
            const formEditarUsuario = document.getElementById('usuarioEditForm');
            const buttonActualizar = document.getElementById('buttonUpdate');


            buttonActualizar.addEventListener('click', function(e) {
                e.preventDefault();

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

                    })
                    .catch(error => {
                        console.error('Error al guardar los datos:', error);


                        if (error.message) {
                            alert(error.message);
                        } else {
                            alert('Error al guardar los datos. Por favor, intente de nuevo.');
                        }


                        if (error.errors) {

                            for (let field in error.errors) {
                                alert(`Error en ${field}: ${error.errors[field].join(', ')}`);
                            }
                        }
                    });
            });



            // CAMBIAR CONTRASEÑA
            const formCambiarContrasena = document.getElementById('cambiarContrasenaForm');
            const buttonChangePassword = document.getElementById('buttonChangePassword');

            buttonChangePassword.addEventListener('click', function(e) {
                e.preventDefault(); // Prevenir el envío normal del formulario

                const formData = new FormData(formCambiarContrasena);

                fetch("{{ role_route('usuarios.changePassword') }}", { // Asegúrate de que esta ruta sea correcta
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
                        console.log('Contraseña cambiada exitosamente:', data);
                        alert('Contraseña cambiada exitosamente');
                    })
                    .catch(error => {
                        console.error('Error al cambiar la contraseña:', error);

                        if (error.message) {
                            alert(error.message);
                        } else {
                            alert('Error al cambiar la contraseña. Por favor, intente de nuevo.');
                        }

                        if (error.errors) {
                            for (let field in error.errors) {
                                alert(`Error en ${field}: ${error.errors[field].join(', ')}`);
                            }
                        }
                    });
            });


        });
    </script>
@endsection
