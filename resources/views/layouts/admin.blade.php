<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- <script src="https://kit.fontawesome.com/ad9c87abbe.js" crossorigin="anonymous"></script> --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/trackr_favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/styles.min.css') }}" />
    @livewireStyles
</head>
<body>
    <div class="page-wrapper bg-body-white" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        @include('layouts.inc._sidebar')

        <div class="body-wrapper">
            @include('layouts.inc._header')

            <div class="container-fluid">
                <!-- Title -->
                <div class="row py-2">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h3 class="page-title"> @yield('pagename') </h3>
                            <nav class="d-md-none">
                                @yield('breadcrumbs')
                            </nav>
                        </div>
                        <div class="ms-0 d-none d-md-block">
                            <nav>
                                @yield('breadcrumbs')
                            </nav>
                        </div>
                    </div>
                </div>
                <!-- End Title -->
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ asset('admin/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('admin/assets/js/app.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/simplebar/dist/simplebar.js') }}"></script>

    @livewireScripts
    @yield('scripts')

</body>
</html>
