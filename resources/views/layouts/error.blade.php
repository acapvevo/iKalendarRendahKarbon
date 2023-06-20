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
        href="https://cdn.datatables.net/v/bs5/dt-1.13.4/b-2.3.6/b-html5-2.3.6/fh-3.3.2/r-2.4.1/sb-1.4.2/datatables.min.css"
        rel="stylesheet" />

    <!-- SWEET ALERT 2 CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.10/dist/sweetalert2.min.css">

    <!-- EASYMDE CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- FLATPICKR CSS-->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- APP CSS-->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    @livewireStyles

    <!-- PAGE SPECIFIC CSS-->
    @yield('styles')
</head>

<body class="bg-white">
    <div id="layoutError">
        <div id="layoutError_content">
            <main>
                <div class="container-xl px-4">
                    <div class="row justify-content-center">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutError_footer">
            @include('layouts.footer')
        </div>
    </div>

    <!-- JQUERY JS-->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" crossorigin="anonymous"></script>

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

    <!-- CHART JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.0/chart.umd.min.js"></script>

    <!-- JSZIP JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>

    <!-- PDFMAKE JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- DATATABLE JS-->
    <script
        src="https://cdn.datatables.net/v/bs5/dt-1.13.4/b-2.3.6/b-html5-2.3.6/fh-3.3.2/r-2.4.1/sb-1.4.2/datatables.min.js">
    </script>
    <script src="https://cdn.datatables.net/plug-ins/1.13.4/sorting/natural.js"></script>

    <!-- SWEET ALERT 2 JS-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.10/dist/sweetalert2.all.min.js"></script>

    <!-- EASYMDE JS-->
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>

    <!-- FLATPICKR JS-->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- APP JS-->
    <script src="{{ asset('js/scripts.js') }}"></script>
    @livewireScripts

    <!-- PAGE SPECIFIC JS-->
    @yield('scripts')
</body>

</html>
