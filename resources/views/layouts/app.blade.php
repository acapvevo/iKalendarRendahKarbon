<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title') - @yield('apps')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}" />

    <!-- FONT AWESOME CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        crossorigin="anonymous" />

    <!-- DATATABLE CSS-->
    <link
        href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.5/b-2.4.1/b-html5-2.4.1/fc-4.3.0/fh-3.4.0/sb-1.5.0/datatables.min.css"
        rel="stylesheet">

    <!-- SWEET ALERT 2 CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.10/dist/sweetalert2.min.css">

    <!-- APP CSS-->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    @livewireStyles

    <!-- PAGE SPECIFIC CSS-->
    @yield('styles')
    @stack('styles')
</head>

<body class="{{ isset($isRTL) && $isRTL ? 'layout-rtl' : '' }} nav-fixed">
    <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white"
        id="sidenavAccordion">
        <!-- Sidenav Toggle Button-->
        <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i
                data-feather="menu"></i></button>
        @include('components.logo', ['home' => $home])
        <!-- Navbar Items-->
        <ul class="navbar-nav align-items-center ms-auto">
            <!-- Alerts Dropdown-->
            <li class="nav-item dropdown no-caret d-none d-sm-block me-3 dropdown-notifications">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownAlerts"
                    href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><i data-feather="bell"
                        class="{{ isset($alertCount) && $alertCount ? 'link-danger' : 'link-primary' }}"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up"
                    aria-labelledby="navbarDropdownAlerts">
                    <h6 class="dropdown-header dropdown-notifications-header">
                        <i class="me-2" data-feather="bell"></i>
                        {{ __('Alerts Center') }} &nbsp;{!! isset($alertCount) && $alertCount ? '<span class="badge bg-danger">{$alertCount}</span>' : '' !!}
                    </h6>
                    @yield('alerts')
                    <a class="dropdown-item dropdown-notifications-footer"
                        href="#!">{{ __('View All Alerts') }}</a>
                </div>
            </li>
            <!-- Messages Dropdown-->
            <li class="nav-item dropdown no-caret d-none d-sm-block me-3 dropdown-notifications">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownMessages"
                    href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><i data-feather="mail"
                        class="{{ isset($messageCount) && $messageCount ? 'link-danger' : 'link-primary' }}"></i></a>
                <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up"
                    aria-labelledby="navbarDropdownMessages">
                    <h6 class="dropdown-header dropdown-notifications-header">
                        <i class="me-2" data-feather="mail"></i>
                        {{ __('Message Center') }} &nbsp;{!! isset($messageCount) && $messageCount ? '<span class="badge bg-danger">{$messageCount}</span>' : '' !!}
                    </h6>
                    @yield('messages')
                    <!-- Footer Link-->
                    <a class="dropdown-item dropdown-notifications-footer"
                        href="#!">{{ __('Read All Messages') }}</a>
                </div>
            </li>
            <!-- User Dropdown-->
            <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage"
                    href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><img class="img-fluid" src="@yield('picture')" /></a>
                <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up"
                    aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        <img class="dropdown-user-img" src="@yield('picture')" />
                        <div class="dropdown-user-details">
                            <div class="dropdown-user-details-name">@yield('name')</div>
                            <div class="dropdown-user-details-email">@yield('email')</div>
                        </div>
                    </h6>
                    <div class="dropdown-divider"></div>
                    @yield('topmenu')
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sidenav shadow-right @yield('sidenav_colour', 'sidenav-light')">
                <div class="sidenav-menu">
                    <div class="nav accordion" id="accordionSidenav">
                        <!-- Sidenav Menu Heading (Account)-->
                        <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                        <div class="sidenav-menu-heading d-sm-none">{{ __('Account') }}</div>
                        <!-- Sidenav Link (Alerts)-->
                        <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                        <a class="nav-link d-sm-none" href="@yield('alert-href')">
                            <div class="nav-link-icon"><i data-feather="bell"></i></div>
                            {{ __('Alerts') }}
                            {!! isset($alertCount) && $alertCount
                                ? '<span class="badge bg-warning-soft text-warning ms-auto">{$alertCount} New!</span>'
                                : '' !!}
                        </a>
                        <!-- Sidenav Link (Messages)-->
                        <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                        <a class="nav-link d-sm-none" href="@yield('message-href')">
                            <div class="nav-link-icon"><i data-feather="mail"></i></div>
                            {{ __('Messages') }}
                            {!! isset($messageCount) && $messageCount
                                ? '<span class="badge bg-warning-soft text-warning ms-auto">{$messageCount} New!</span>'
                                : '' !!}
                        </a>
                        @yield('sidemenu')
                    </div>
                </div>
                <!-- Sidenav Footer-->
                <div class="sidenav-footer">
                    <div class="sidenav-footer-content">
                        <div class="sidenav-footer-subtitle">{{ __('Logged in as') }}:</div>
                        <div class="sidenav-footer-title">@yield('name')</div>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                @yield('header')
                <!-- Main page content-->
                @yield('content')
            </main>
            @include('layouts.footer')
        </div>
    </div>

    <!-- JQUERY JS-->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" crossorigin="anonymous">
    </script>

    <!-- FONT AWESOME JS-->
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"
        crossorigin="anonymous"></script>

    <!-- FEATHER ICONS JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous">
    </script>

    <!-- ICONIFY JS-->
    <script src="https://code.iconify.design/iconify-icon/1.0.0-beta.3/iconify-icon.min.js"></script>

    <!-- BOOTSTRAP JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <!-- DATATABLE JS-->
    <script
        src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.5/b-2.4.1/b-html5-2.4.1/fc-4.3.0/fh-3.4.0/sb-1.5.0/datatables.min.js">
    </script>
    <script src="https://cdn.datatables.net/plug-ins/1.13.4/sorting/natural.js"></script>

    <!-- SWEET ALERT 2 JS-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.10/dist/sweetalert2.all.min.js"></script>

    @livewireScripts

    <!-- ALPINE JS-->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <x-livewire-alert::scripts />
    @include('components.alert')


    <!-- Datatables Global Setting-->
    <script>
        $.extend(true, $.fn.dataTable.defaults, {
            "order": [],
            language: {
                url: '{{ asset('js/datatables/lang/' . LaravelLocalization::getCurrentLocale() . '.json') }}'
            },
            columnDefs: [{
                targets: '_all',
                className: 'dt-center'
            }],
            scrollX: true,
            fixedHeader: true
        });
        $.fn.dataTable.ext.errMode = 'none';
    </script>

    <!-- PAGE SPECIFIC JS-->
    @yield('scripts')
    @stack('scripts')
</body>

</html>
