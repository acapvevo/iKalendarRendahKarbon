@extends('template.layouts.app')

@section('title', 'Groups List')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
@endsection

@section('header')
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="users"></i></div>
                            Groups List
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="user-management-list.html">
                            <i class="me-1" data-feather="user"></i>
                            Manage Users
                        </a>
                        <button class="btn btn-sm btn-light text-primary" type="button" data-bs-toggle="modal"
                            data-bs-target="#createGroupModal">
                            <i class="me-1" data-feather="plus"></i>
                            Create New Group
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container-fluid px-4">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatablesSimple" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Group Name</th>
                                <th>Total Members</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Group Name</th>
                                <th>Total Members</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr>
                                <td>Sales</td>
                                <td>8</td>
                                <td>20 Jun 2021</td>
                                <td>
                                    <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" type="button"
                                        data-bs-toggle="modal" data-bs-target="#editGroupModal"><i
                                            data-feather="edit"></i></button>
                                    <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i
                                            data-feather="trash-2"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>Developers</td>
                                <td>6</td>
                                <td>20 Jun 2021</td>
                                <td>
                                    <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" type="button"
                                        data-bs-toggle="modal" data-bs-target="#editGroupModal"><i
                                            data-feather="edit"></i></button>
                                    <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i
                                            data-feather="trash-2"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>Marketing</td>
                                <td>3</td>
                                <td>20 Jun 2021</td>
                                <td>
                                    <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" type="button"
                                        data-bs-toggle="modal" data-bs-target="#editGroupModal"><i
                                            data-feather="edit"></i></button>
                                    <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i
                                            data-feather="trash-2"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>Managers</td>
                                <td>6</td>
                                <td>20 Jun 2021</td>
                                <td>
                                    <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" type="button"
                                        data-bs-toggle="modal" data-bs-target="#editGroupModal"><i
                                            data-feather="edit"></i></button>
                                    <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i
                                            data-feather="trash-2"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>Customer</td>
                                <td>10</td>
                                <td>20 Jun 2021</td>
                                <td>
                                    <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" type="button"
                                        data-bs-toggle="modal" data-bs-target="#editGroupModal"><i
                                            data-feather="edit"></i></button>
                                    <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i
                                            data-feather="trash-2"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Create group modal-->
    <div class="modal fade" id="createGroupModal" tabindex="-1" role="dialog" aria-labelledby="createGroupModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createGroupModalLabel">Create New Group</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-0">
                            <label class="mb-1 small text-muted" for="formGroupName">Group Name</label>
                            <input class="form-control" id="formGroupName" type="text"
                                placeholder="Enter group name..." />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger-soft text-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary-soft text-primary" type="button">Create New Group</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit group modal-->
    <div class="modal fade" id="editGroupModal" tabindex="-1" role="dialog" aria-labelledby="editGroupModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGroupModalLabel">Edit Group</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-0">
                            <label class="mb-1 small text-muted" for="formGroupName">Group Name</label>
                            <input class="form-control" id="formGroupName" type="text"
                                placeholder="Enter group name..." value="Sales" />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger-soft text-danger" type="button"
                        data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary-soft text-primary" type="button">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables/datatables-simple-demo.js') }}"></script>
@endsection
