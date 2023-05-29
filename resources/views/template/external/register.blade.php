@extends('layouts.guest')

@section('classname', 'app-signup')

@section('title')
    <h2 class="auth-heading text-center mb-5">Sign up to Portal</h2>
@endsection

@section('content')

    <div class="auth-form-container text-start mx-auto">
        <form class="auth-form auth-signup-form">
            <div class="email mb-3">
                <label class="sr-only" for="signup-email">Your Name</label>
                <input id="signup-name" name="signup-name" type="text" class="form-control signup-name"
                    placeholder="Full name" required="required">
            </div>
            <div class="email mb-3">
                <label class="sr-only" for="signup-email">Your Email</label>
                <input id="signup-email" name="signup-email" type="email" class="form-control signup-email"
                    placeholder="Email" required="required">
            </div>
            <div class="password mb-3">
                <label class="sr-only" for="signup-password">Password</label>
                <input id="signup-password" name="signup-password" type="password" class="form-control signup-password"
                    placeholder="Create a password" required="required">
            </div>
            <div class="extra mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="RememberPassword">
                    <label class="form-check-label" for="RememberPassword">
                        I agree to Portal's <a href="#" class="app-link">Terms of Service</a> and <a href="#"
                            class="app-link">Privacy Policy</a>.
                    </label>
                </div>
            </div>
            <!--//extra-->

            <div class="text-center">
                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Sign
                    Up</button>
            </div>
        </form>
        <!--//auth-form-->

        <div class="auth-option text-center pt-5">Already have an account? <a class="text-link" href="login.html">Log in</a>
        </div>
    </div>
    <!--//auth-form-container-->
@endsection
