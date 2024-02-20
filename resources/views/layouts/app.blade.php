<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @hasSection('title')
        <title>@yield('title') - {{ config('app.name') }}</title>
        @else
        <title>Vehicle Repair Shop</title>
        @endif

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

        <!-- Styles -->
        {{-- @livewireStyles --}}
        <link rel="shortcut icon"
            href="{{ asset('assets/images/logo-repair.webp') }}" />
        <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
            type="text/css" />
        <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
            type="text/css" />
        <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @yield('styles')
    </head>

    <body data-kt-name="mitra_panen" id="kt_app_body" data-kt-app-layout="light-sidebar" data-kt-app-header-fixed="true"
        data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
        data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
        data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
        <script>
            if (document.documentElement) {
                const defaultThemeMode = "system";
                const name = document.body.getAttribute("data-kt-name");
                let themeMode = localStorage.getItem("kt_" + (name !== null ? name + "_" : "") + "theme_mode_value");
                if (themeMode === null) {
                    if (defaultThemeMode === "system") {
                        themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
                    } else {
                        themeMode = defaultThemeMode;
                    }
                }
                document.documentElement.setAttribute("data-theme", themeMode);
            }
        </script>
        <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
            <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
                <x-header />
                <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                    <x-sidebar />
                    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                        <div class="d-flex flex-column flex-column-fluid">
                            @hasSection('page-title')
                            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                                <div id="kt_app_toolbar_container"
                                    class="app-container container-fluid d-flex flex-stack">
                                    @yield('page-title')
                                </div>
                            </div>
                            @endif
                            <div id="kt_app_content" class="app-content flex-column-fluid pt-0">
                                <div id="kt_app_content_container" class="app-container container-fluid">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                        <div id="kt_app_footer" class="app-footer">
                            <div
                                class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                                <div class="text-dark order-2 order-md-1">
                                    <span class="text-muted fw-semibold me-1">{{ now()->year }}©</span>
                                    <a href="{{ config('app.url', '#') }}" target="_blank"
                                        class="text-gray-800 text-hover-primary">{{ config('app.name', 'AutoRepair')
                                        }} - M. Syifa'ul Ikrom Al Masyriqi - Monitoring System Vehicle Repair Shop</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
            <span class="svg-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)"
                        fill="currentColor" />
                    <path
                        d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                        fill="currentColor" />
                </svg>
            </span>
        </div>
        <!-- Scripts -->
        @include('sweetalert::alert')
        <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
        <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
        <script src="{{ asset('assets/plugins/custom/tinymce/tinymce.bundle.js') }}"></script>
        <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
        <script src="{{asset('assets/js/my_scripts.js')}}"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        @stack('scripts')
    </body>
</html>