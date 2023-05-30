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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7/dist/sweetalert2.min.css">
    <link id="theme-style" rel="stylesheet" href="{{ asset('assets/css/portal.css') }}">
    @livewireStyles

    <!-- Page Specific CSS -->
    @yield('styles')

</head>

<body class="app @yield('classname') p-0">
    <div class="row g-0 app-auth-wrapper">
        <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
            <div class="d-flex flex-column align-content-end">
                <div class="app-auth-body mx-auto">
                    @include('components.logo.guest')

                    @yield('title')

                    @yield('content')

                </div>
                <!--//auth-body-->

                <footer class="app-auth-footer">
                    @include('components.footer')
                </footer>
                <!--//app-auth-footer-->
            </div>
            <!--//flex-column-->
        </div>
        <!--//auth-main-col-->
        <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
            <div class="auth-background-holder">
            </div>
            <div class="auth-background-mask"></div>
            <div class="auth-background-overlay p-3 p-lg-5">
                <div class="d-flex flex-column align-content-end h-100">
                    <div class="h-100"></div>
                    <div class="overlay-content p-3 p-lg-4 rounded">
                        <h5 class="mb-3 overlay-title">Explore Portal Admin Template</h5>
                        <div>Portal is a free Bootstrap 5 admin dashboard template. You can download and view the
                            template license <a
                                href="https://themes.3rdwavemedia.com/bootstrap-templates/admin-dashboard/portal-free-bootstrap-admin-dashboard-template-for-developers/">here</a>.
                        </div>
                    </div>
                </div>
            </div>
            <!--//auth-background-overlay-->
        </div>
        <!--//auth-background-col-->

    </div>
    <!--//row-->

    <!-- App JS -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.7/dist/iconify-icon.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.slim.js"
        integrity="sha256-7GO+jepT9gJe9LB4XFf8snVOjX3iYNb0FHYr5LI1N5c=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7/dist/sweetalert2.all.min.js"></script>
    @livewireScripts

    @include('components.alert')

    <!-- Page Specific JS -->
    @yield('scripts')


</body>

</html>
