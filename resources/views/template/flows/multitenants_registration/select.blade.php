@extends('layouts.guest')

@yield('apps', 'SB Admin Pro')

@yield('title', 'Create or Join Organization')

@section('content')
    <!-- Create Organization-->
    <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11 mt-4">
        <div class="card text-center h-100">
            <div class="card-body px-5 pt-5 d-flex flex-column">
                <div>
                    <div class="h3 text-primary">Create</div>
                    <p class="text-muted mb-4">Create an organization and invite new members</p>
                </div>
                <div class="icons-org-create align-items-center mx-auto mt-auto">
                    <i class="icon-users" data-feather="users"></i>
                    <i class="icon-plus fas fa-plus"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent px-5 py-4">
                <div class="small text-center"><a class="btn btn-block btn-primary"
                        href="{{ route('template.flows.multitenants_registration.create') }}">Create
                        new organization</a></div>
            </div>
        </div>
    </div>
    <!-- Join Organization-->
    <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11 mt-4">
        <div class="card text-center h-100">
            <div class="card-body px-5 pt-5 d-flex flex-column align-items-between">
                <div>
                    <div class="h3 text-secondary">Join</div>
                    <p class="text-muted mb-4">Enter an access code or request access to an existing organization</p>
                </div>
                <div class="icons-org-join align-items-center mx-auto">
                    <i class="icon-user" data-feather="user"></i>
                    <i class="icon-arrow fas fa-long-arrow-alt-right"></i>
                    <i class="icon-users" data-feather="users"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent px-5 py-4">
                <div class="small text-center"><a class="btn btn-block btn-secondary"
                        href="{{ route('template.flows.multitenants_registration.join') }}">Join an
                        organization</a></div>
            </div>
        </div>
    </div>
@endsection
