@extends('layouts.guest')

@yield('apps', 'SB Admin Pro')

@yield('title', 'Forgot Password')

@section('content')
    <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11">
        <!-- Social forgot password form-->
        <div class="card my-5">
            <div class="card-body p-5 text-center">
                <div class="h3 fw-light mb-0">Password Recovery</div>
            </div>
            <hr class="my-0" />
            <div class="card-body p-5">
                <div class="text-center small text-muted mb-4">Enter your email address below and we will send you a link to
                    reset your password.</div>
                <!-- Forgot password form-->
                <form>
                    <!-- Form Group (email address)-->
                    <div class="mb-3">
                        <label class="text-gray-600 small" for="emailExample">Email address</label>
                        <input class="form-control form-control-solid" type="text" placeholder=""
                            aria-label="Email Address" aria-describedby="emailExample" />
                    </div>
                    <!-- Form Group (reset password button)    -->
                    <a class="btn btn-primary" href="auth-login-social.html">Reset Password</a>
                </form>
            </div>
            <hr class="my-0" />
            <div class="card-body px-5 py-4">
                <div class="small text-center">
                    New user?
                    <a href="auth-register-social.html">Create an account!</a>
                </div>
            </div>
        </div>
    </div>
@endsection