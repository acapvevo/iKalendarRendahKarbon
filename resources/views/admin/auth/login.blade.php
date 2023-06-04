@extends('layouts.guest')

@section('classname', 'app-login')

@section('title')
    <h2 class="auth-heading text-center mb-5">Log in to Portal</h2>
@endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Oops!, Something went wrong.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="auth-form-container text-start">
        <form class="auth-form login-form" action="{{ route('admin.login') }}" method="post">
            @csrf

            <div class="input-group mb-3">
                <span class="input-group-text" id="username">
                    <i class="fa-solid fa-user"></i>
                </span>
                <input type="text" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                    placeholder="Enter Your Username" id="username" name="username" aria-label="Username" aria-describedby="username"
                    value="{{ old('username') }}">
                @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="password">
                    <i class="fa-solid fa-key"></i>
                </span>
                <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    placeholder="Enter Your Password" id="password" name="password" aria-label="password" aria-describedby="password"
                    value="{{ old('password') }}">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="extra mt-3 row justify-content-between">
                <div class="col-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>
                </div>
                <!--//col-6-->
                <div class="col-6">
                    <div class="forgot-password text-end">
                        <a href="{{ route('admin.password.request') }}">Forgot password?</a>
                    </div>
                </div>
                <!--//col-6-->
            </div>
            <!--//extra-->

            <!--//form-group-->
            <div class="text-center">
                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Log
                    In</button>
            </div>
        </form>

        <div class="auth-option text-center pt-5">No Account? Sign up <a class="text-link"
                href="{{ route('admin.register') }}">here</a>.
        </div>
    </div>
    <!--//auth-form-container-->
@endsection
