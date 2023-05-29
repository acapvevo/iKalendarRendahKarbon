@extends('layouts.guest')

@section('classname', 'app-login')

@section('title')
    <h2 class="auth-heading text-center mb-5">Log in to Portal</h2>
@endsection

@section('content')
    <div class="auth-form-container text-start">
        <form class="auth-form login-form">
            <div class="email mb-3">
                <label class="sr-only" for="signin-email">Email</label>
                <input id="signin-email" name="signin-email" type="email" class="form-control signin-email"
                    placeholder="Email address" required="required">
            </div>
            <!--//form-group-->
            <div class="password mb-3">
                <label class="sr-only" for="signin-password">Password</label>
                <input id="signin-password" name="signin-password" type="password" class="form-control signin-password"
                    placeholder="Password" required="required">
                <div class="extra mt-3 row justify-content-between">
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="RememberPassword">
                            <label class="form-check-label" for="RememberPassword">
                                Remember me
                            </label>
                        </div>
                    </div>
                    <!--//col-6-->
                    <div class="col-6">
                        <div class="forgot-password text-end">
                            <a href="reset-password.html">Forgot password?</a>
                        </div>
                    </div>
                    <!--//col-6-->
                </div>
                <!--//extra-->
            </div>
            <!--//form-group-->
            <div class="text-center">
                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Log
                    In</button>
            </div>
        </form>

        <div class="auth-option text-center pt-5">No Account? Sign up <a class="text-link" href="signup.html">here</a>.
        </div>
    </div>
    <!--//auth-form-container-->
@endsection
