@extends('errors.template.template')
<!-- Error -->
@section('content')
    <div class="misc-wrapper">
        <h4 class="mb-2 mx-2">Acceso Denegado ⚠️</h4>
        <p class="mb-6 mx-2">La empresa está bloqueada por falta de pago. Por favor, contacte al soporte para más información.</p>
        <div class="mt-4">
            <img src="{{ asset('img/illustrations/auth-reset-password-illustration-light.png') }}" alt="auth-reset-password-illustration-light" width="225" class="img-fluid" />
        </div>
    </div>
@endsection
@section('image')
    <div class="container-fluid misc-bg-wrapper">
        <img src="{{ asset('img/illustrations/bg-shape-image-light.png') }}" height="355" alt="page-misc-error" data-app-light-img="illustrations/bg-shape-image-light.png" data-app-dark-img="illustrations/bg-shape-image-dark.png" />
    </div>
@endsection
