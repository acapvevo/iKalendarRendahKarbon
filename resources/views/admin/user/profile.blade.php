@extends('admin.layouts.app')

@section('title')
    <h1 class="app-page-title">User Profile</h1>
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="#">User</a></li>
    <li class="breadcrumb-item active" aria-current="page">Profile</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="pt-3 pb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateUserModal">
                    Update
                </button>
            </div>
            <div class="table-repsonsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="w-25">Name</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th class="w-25">Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateUserModalLabel">Update User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @livewire('admin.user.profile', ['user' => $user])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick='$("#updateUserForm").trigger("reset");'
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="updateUserForm">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if ($errors->any())
        <script>
            showModalOnError('updateUserModal')
        </script>
    @endif
@endsection
