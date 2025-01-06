<!doctype html>
<html
  lang="en"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../"
  data-template="vertical-menu-template"
  data-style="light">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{$title}}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('css/rtl/core.css') }}" class="template-customizer-core-css"/>
    <link rel="stylesheet" href="{{ asset('css/rtl/theme-default.css') }}" class="template-customizer-theme-css"/>

    <link rel="stylesheet" href="{{ asset('css/demo.css') }}" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('css/node-waves.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/perfect-scrollbar.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/typeahead.css') }}"/>

    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('css/pages/page-auth.css') }}"/>
    <style>
        .misc-wrapper {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 3rem);
            text-align: center;
        }

        .misc-bg-wrapper {
            position: relative;
        }
        .misc-bg-wrapper img {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: -1;
        }

        @media (max-width: 1499.98px) {
            .misc-bg-wrapper img {
                height: 250px;
            }
            .misc-under-maintenance-bg-wrapper img {
                height: 270px !important;
            }
        }
    </style>
    <!-- Helpers -->
    <script src="{{ asset('js/helpers.js') }}"></script>
    <script src="{{ asset('js/template-customizer.js') }}"></script>
    <script src="{{ asset('js/config.js') }}"></script>
  </head>

  <body>
    <div class="container-xxl container-p-y">
        @yield('content')
    </div>
    <div class="container-fluid misc-bg-wrapper">
        @yield('image')
    </div>

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/node-waves.js') }}"></script>
    <script src="{{ asset('js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('js/hammer.js') }}"></script>
    <script src="{{ asset('js/i18n.js') }}"></script>
    <script src="{{ asset('js/typeahead.js') }}"></script>
    <script src="{{ asset('js/menu.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('js/main.js') }}"></script>
    <!-- Page JS -->
  </body>
</html>
