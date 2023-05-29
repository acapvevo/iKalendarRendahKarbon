@php
    $guards = array_keys(config('auth.guards'));
    foreach ($guards as $guard) {
        if (
            auth()
                ->guard($guard)
                ->check()
        ) {
            return $guard;
        }
    }
    $guard = 'admin';
@endphp

<div class="app-branding">
    <a class="app-logo" href="{{route($guard . '.dashboard')}}"><img class="logo-icon me-2" src="{{asset('assets/images/app-logo.svg')}}" alt="logo"><span
            class="logo-text">PORTAL</span></a>

</div>
