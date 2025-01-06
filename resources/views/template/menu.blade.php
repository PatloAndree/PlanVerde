<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                        fill="#9dc140" />
                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                        d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                        d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                        fill="#9dc140" />
                </svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bold">Plan verde</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <!-- ******************  SUPERADMINISTRADOR  ***************** -->
        @role('superadministrador')
            <!-- Page -->
            @can('empresas.show')
                <li class="menu-item {{ Route::is('empresas.show') ? 'active' : '' }}">
                    <a href="{{ route('empresas.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-smart-home"></i>
                        <div data-i18n="Page 1">Empresas</div>
                    </a>
                </li>
            @endcan
            @can('actividades.show')
                <li class="menu-item {{ Route::is('actividades.show') ? 'active' : '' }}">
                    <a href="{{ route('actividades.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-calendar"></i>
                        <div data-i18n="Page 2">Actividades</div>
                    </a>
                </li>
            @endcan
            @can('pagos.show')
                <li class="menu-item {{ Route::is('superadministrador.pagos.show') ? 'active' : '' }}">
                    <a href="{{ route('superadministrador.pagos.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-credit-card"></i>
                        <div data-i18n="Page 2">Pagos</div>
                    </a>
                </li>
            @endcan

            @can('encuestas.show')
                <li class="menu-item {{ Route::is('superadministrador.encuestas.show') ? 'active' : '' }}">
                    <a href="{{ route('superadministrador.encuestas.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-clipboard-data"></i>
                        <div data-i18n="Page 2">Encuestas</div>
                    </a>
                </li>
            @endcan

            @can('documentos.show')
                <li class="menu-item {{ Route::is('documentos.show') ? 'active' : '' }}">
                    <a href="{{ route('documentos.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-id"></i>
                        <div data-i18n="Page 2">Documentos</div>
                    </a>
                </li>
            @endcan
            @can('reportes.show')
                <li class="menu-item {{ Route::is('reportes.show') ? 'active' : '' }}">
                    <a href="{{ route('reportes.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-chart-bar"></i>
                        <div data-i18n="Page 2">Reportes</div>
                    </a>
                </li>
            @endcan
            @can('usuarios.show')
                <li class="menu-item {{ Route::is('usuarios.show') ? 'active' : '' }}">
                    <a href="{{ route('superadministrador.usuarios.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-user"></i>
                        <div data-i18n="Page 2">Usuarios</div>
                    </a>
                </li>
            @endcan
            @can('configuracion.show')
                <li class="menu-item {{ Route::is('configuracion.show') ? 'active' : '' }}">
                    <a href="{{ route('superadministrador.configuracion.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-settings"></i>
                        <div data-i18n="Page 2">Configuración</div>
                    </a>
                </li>
            @endcan
        @endrole
        <!-- ******************  ADMINISTRADOR  ***************** -->
        @role('administrador')
            @can('usuarios.show')
                <li class="menu-item {{ Route::is('administrador.usuarios.show') ? 'active' : '' }}">
                    <a href="{{ route('administrador.usuarios.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-user"></i>
                        <div data-i18n="Page 2">Usuarios</div>
                    </a>
                </li>
            @endcan
            @can('documentos.show')
                <li class="menu-item {{ Route::is('documentos.show') ? 'active' : '' }}">
                    <a href="{{ route('documentos.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-id"></i>
                        <div data-i18n="Page 2">Documentos</div>
                    </a>
                </li>
            @endcan
            <li class="menu-item {{ Route::is('administrador.encuestas.show') ? 'active' : '' }}">
                <a href="{{ route('administrador.encuestas.show') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-clipboard-data"></i>
                    <div data-i18n="Page 2">Encuestas</div>
                </a>
            </li>
            @can('configuracion.show')
                <li class="menu-item {{ Route::is('administrador.configuracion.show') ? 'active' : '' }}">
                    <a href="{{ route('administrador.configuracion.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-settings"></i>
                        <div data-i18n="Page 2">Configuración</div>
                    </a>
                </li>
            @endcan
            <li class="menu-item {{ Route::is('administrador.formatos.show') ? 'active' : '' }}">
                <a href="{{ route('administrador.formatos.show') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-file-spreadsheet"></i>
                    <div data-i18n="Page 2">Formatos</div>
                </a>
            </li>
        @endrole
        <!--****************** MARKETING****************** -->
        @role('marketing')
            @can('archivos.show')
                <li class="menu-item {{ Route::is('marketing.archivos.show') ? 'active' : '' }}"">
                    <a href="{{ route('marketing.archivos.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-video"></i>
                        <div data-i18n="Page 2">Archivos</div>
                    </a>
                </li>
            @endcan
            @can('cotizaciones.show')
                <li class="menu-item {{ Route::is('marketing.cotizaciones.show') ? 'active' : '' }}"">
                    <a href="{{ route('marketing.cotizaciones.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-file"></i>
                        <div data-i18n="Page 2">Cotizaciones</div>
                    </a>
                </li>
            @endcan
            @can('mensajes.show')
                <li class="menu-item {{ Route::is('marketing.mensajes.show') ? 'active' : '' }}"">
                    <a href="{{ route('marketing.mensajes.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-message"></i>
                        <div data-i18n="Page 2">Mensajes</div>
                    </a>
                </li>
            @endcan
            @can('foro.show')
                <li class="menu-item {{ Route::is('marketing.foro.show') ? 'active' : '' }}"">
                    <a href="{{ route('marketing.foro.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-album"></i>
                        <div data-i18n="Page 2">Foro</div>
                    </a>
                </li>
            @endcan
            @can('contactos.show')
                <li class="menu-item {{ Route::is('marketing.contactos.show') ? 'active' : '' }}"">
                    <a href="{{ route('marketing.contactos.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-message"></i>
                        <div data-i18n="Page 2">Contactos</div>
                    </a>
                </li>
            @endcan
        @endrole
        <!--****************** SOPORTE ******************-->
        @role('soporte')
            @can('usuarios.show')
                <li class="menu-item {{ Route::is('soporte.documentosSoporte.show') ? 'active' : '' }}">
                    <a href="{{ route('soporte.documentosSoporte.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-file"></i>
                        <div data-i18n="Page 2">Documentos</div>
                    </a>
                </li>
            @endcan
            @can('usuarios.show')
                <li class="menu-item {{ Route::is('soporte.tickets.show') ? 'active' : '' }}">
                    <a href="{{ route('soporte.tickets.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-ticket"></i>
                        <div data-i18n="Page 2">Tickets</div>
                    </a>
                </li>
            @endcan
            @can('usuarios.show')
                <li class="menu-item {{ Route::is('soporte.preguntasFaqs.show') ? 'active' : '' }}">
                    <a href="{{ route('soporte.preguntasFaqs.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-help-hexagon"></i>
                        <div data-i18n="Page 2">Preguntas frec. FAQS</div>
                    </a>
                </li>
            @endcan
        @endrole
        <!--****************** CLIENTES ******************-->
        @role('cliente')
            @can('usuarios.show')
                <!--li class="menu-item {{ Route::is('cliente.usuarios.show') ? 'active' : '' }}">
                        <a href="{{ route('cliente.usuarios.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-user"></i>
                        <div data-i18n="Page 2">Usuarios</div>
                        </a>
                    </li-->
            @endcan
            @can('usuarios.show')
                <li class="menu-item {{ Route::is('cliente.planillas.show') ? 'active' : '' }} ">
                    <a href="{{ route('cliente.planillas.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-file"></i>
                        <div data-i18n="Page 2">Planillas</div>
                    </a>    
                </li>
            @endcan
            @can('usuarios.show')
                <li class="menu-item {{ Route::is('cliente.historial.show') ? 'active' : '' }} ">
                    <a href="{{ route('cliente.historial.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-file-analytics"></i>
                        <div data-i18n="Page 2">Historial</div>
                    </a>
                </li>
            @endcan
            @can('pagos.show')
                <li class="menu-item {{ Route::is('cliente.pagos.show') ? 'active' : '' }}">
                    <a href="{{ route('cliente.pagos.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-credit-card"></i>
                        <div data-i18n="Page 2">Pagos</div>
                    </a>
                </li>
            @endcan
            @can('usuarios.show')
                <li class="menu-item {{ Route::is('cliente.encuestas.show') ? 'active' : '' }}">
                    <a href="{{ route('cliente.encuestas.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-clipboard-data"></i>
                        <div data-i18n="Page 2">Encuestas</div>
                    </a>
                </li>
            @endcan
            @can('foro.show')
                <li class="menu-item {{ Route::is('cliente.foro.show') ? 'active' : '' }}"">
                    <a href="{{ route('cliente.foro.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-album"></i>
                        <div data-i18n="Page 2">Foro</div>
                    </a>
                </li>
            @endcan
            @can('usuarios.show')
                <li class="menu-item {{ Route::is('cliente.actividades.show') ? 'active' : '' }} ">
                    <a href="{{ route('cliente.actividades.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-calendar"></i>
                        <div data-i18n="Page 2">Actividades</div>
                    </a>
                </li>
            @endcan
            @can('usuarios.show')
                <li class="menu-item {{ Route::is('cliente.actas.show') ? 'active' : '' }} ">
                    <a href="{{ route('cliente.actas.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-notebook"></i>
                        <div data-i18n="Page 2">Actas</div>
                    </a>
                </li>
            @endcan
            @can('usuarios.show')
                <li class="menu-item  ">
                    <a href="" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-list-numbers"></i>
                        <div data-i18n="Page 2">programación anual</div>
                    </a>
                </li>
            @endcan
            @can('usuarios.show')
                <li class="menu-item {{ Route::is('cliente.contratos.show') ? 'active' : '' }} ">
                    <a href="{{ route('cliente.contratos.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-license"></i>
                        <div data-i18n="Page 2">Contratos</div>
                    </a>
                </li>
            @endcan
            @can('usuarios.show')
                <li class="menu-item ">
                    <a href="" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-clock-record"></i>
                        <div data-i18n="Page 2">Recordatorios</div>
                    </a>
                </li>
            @endcan
            @can('usuarios.show')
                <li class="menu-item {{ Route::is('cliente.capacitaciones.show') ? 'active' : '' }} ">
                    <a href="{{ route('cliente.capacitaciones.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-file-time"></i>
                        <div data-i18n="Page 2">Capacitaciones</div>
                    </a>
                </li>
            @endcan
            @can('configuracion.show')
                <li class="menu-item {{ Route::is('cliente.configuracion.show') ? 'active' : '' }}">
                    <a href="{{ route('cliente.configuracion.show') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-settings"></i>
                        <div data-i18n="Page 2">Configuración</div>
                    </a>
                </li>
            @endcan
        @endrole
    </ul>
</aside>
