@extends('layouts.guest')

@section('apps', 'SB Admin Pro')

@section('title', 'Forgot Password')

@section('content')
    <div class="col-lg-5">
        <!-- Basic forgot password form-->
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header justify-content-center">
                <h3 class="fw-light my-4">Password Recovery</h3>
            </div>
            <div class="card-body">
                <div class="small mb-3 text-muted">Enter your email address and we will send you a link to reset your
                    password.</div>
                <!-- Forgot password form-->
                <form>
                    <!-- Form Group (email address)-->
                    <div class="mb-3">
                        <label class="small mb-1" for="inputEmailAddress">Email</label>
                        <input class="form-control" id="inputEmailAddress" type="email" aria-describedby="emailHelp"
                            placeholder="Enter email address" />
                    </div>
                    <!-- Form Group (submit options)-->
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <a class="small" href="auth-login-basic.html">Return to login</a>
                        <a class="btn btn-primary" href="auth-login-basic.html">Reset Password</a>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <div class="small"><a href="auth-register-basic.html">Need an account? Sign up!</a></div>
            </div>
        </div>
    </div>
@endsection
