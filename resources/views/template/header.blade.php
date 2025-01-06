<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
        <i class="ti ti-menu-2 ti-md"></i>
        </a>
    </div>
    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <div class="navbar-nav align-items-center">
        <div class="nav-item dropdown-style-switcher dropdown">
            <a
            class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow"
            href="javascript:void(0);"
            data-bs-toggle="dropdown">
            <i class="ti ti-md"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-start dropdown-styles">
            <li>
                <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                <span class="align-middle"><i class="ti ti-sun me-3"></i>Light</span>
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                <span class="align-middle"><i class="ti ti-moon-stars me-3"></i>Dark</span>
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                <span class="align-middle"><i class="ti ti-device-desktop-analytics me-3"></i>System</span>
                </a>
            </li>
            </ul>
        </div>
        </div>

        <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a
            class="nav-link dropdown-toggle hide-arrow p-0"
            href="javascript:void(0);"
            data-bs-toggle="dropdown">
            <div class="avatar avatar-online">
                <img src="{{ asset('img/avatars/1.png') }}" alt="" class="rounded-circle" />

            </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
            <li>
                    <div class="d-flex align-items-center dropdown-item mt-0">
                        <div class="flex-shrink-0 me-2">
                            <div class="avatar avatar-online">
                                <img src="{{ asset('img/avatars/1.png') }}" alt="" class="rounded-circle" />
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">{{Auth::user()->name}}</h6>
                            <small class="text-muted">{{Auth::user()->getRoleNames()->first()}}</small>
                        </div>
                    </div>
            </li>
            <li>
                <div class="dropdown-divider my-1 mx-n2"></div>
            </li>
            <li>
                <a class="dropdown-item" href="{{ role_route('profile.show') }}">
                <i class="ti ti-user me-3 ti-md"></i><span class="align-middle">Mi Perfil</span>
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#">
                <i class="ti ti-settings me-3 ti-md"></i><span class="align-middle">Configuración</span>
                </a>
            </li>
            <li>
                <div class="dropdown-divider my-1 mx-n2"></div>
            </li>
            <li>
                <div class="d-grid px-2 pt-2 pb-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center w-100">
                            <small class="align-middle">Salir</small>
                            <i class="ti ti-logout ms-2 ti-14px"></i>
                        </button>
                    </form>
                </div>

            </li>
            </ul>
        </li>
        <!--/ User -->
        </ul>
    </div>
</nav>
