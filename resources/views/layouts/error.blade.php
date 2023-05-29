<!DOCTYPE html>
<html lang="en">

<head>
    <title>Portal - Bootstrap 5 Admin Dashboard Template For Developers</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <link rel="shortcut icon" href="{{ asset('assets/favicon.ico') }}">

    <!-- FontAwesome JS-->
    <script defer src="{{ asset('assets/plugins/fontawesome/js/all.min.js') }}"></script>

    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="{{ asset('assets/css/portal.css') }}">

    <!-- Page Specific CSS -->
    @yield('styles')
</head>

<body class="app app-404-page">

    <div class="container mb-5">
        <div class="row">
            <div class="col-12 col-md-11 col-lg-7 col-xl-6 mx-auto">
                <div class="app-branding text-center mb-5">
                    @include('components.logo.error')

                </div>
                <!--//app-branding-->
                <div class="app-card p-5 text-center shadow-sm">
                    <h1 class="page-title mb-4">@yield('code')<br><span class="font-weight-light">
                            @yield('message')</span></h1>
                    <div class="mb-4">
                        @yield('description')

                    </div>
                    <a class="btn app-btn-primary" href="{{ route('welcome') }}">Go to home page</a>
                </div>
            </div>
            <!--//col-->
        </div>
        <!--//row-->
    </div>
    <!--//container-->


    <footer class="app-footer">
        @include('components.footer')
    </footer>
    <!--//app-footer-->

    <!-- Javascript -->
    <script src="{{ asset('assets/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Charts JS -->
    <script src="{{ asset('assets/plugins/chart.js/chart.min.js') }}"></script>

    <!-- App JS -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- Page Specific JS -->
    @yield('scripts')

</body>

</html>
