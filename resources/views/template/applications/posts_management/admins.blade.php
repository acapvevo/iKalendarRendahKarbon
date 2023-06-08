@extends('template.layouts.app')

@section('title', 'Posts Admin')

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
                            <div class="page-header-icon"><i data-feather="list"></i></div>
                            Posts Admin
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="blog-management-create-post.html">
                            <i class="me-1" data-feather="plus"></i>
                            Create New Post
                        </a>
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
                            <th>Post Title</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Author</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Post Title</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Author</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td>Boots on the Ground, Inclusive Thought Provoking Ideas</td>
                            <td>20 Jun 2021</td>
                            <td>
                                <div class="badge bg-gray-200 text-dark">Draft</div>
                            </td>
                            <td>Valerie Luna</td>
                            <td>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                    href="blog-management-edit-post.html"><i data-feather="edit"></i></a>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i
                                        data-feather="trash-2"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>Invest In Social Impact</td>
                            <td>19 Jun 2021</td>
                            <td>
                                <div class="badge bg-yellow-soft text-yellow">Awaiting Approval</div>
                            </td>
                            <td>Aariz Fischer</td>
                            <td>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                    href="blog-management-edit-post.html"><i data-feather="edit"></i></a>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i
                                        data-feather="trash-2"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>Save the World, Social Entrepreneur</td>
                            <td>18 Jun 2021</td>
                            <td>
                                <div class="badge bg-green-soft text-green">Published</div>
                            </td>
                            <td>Alicia Allen</td>
                            <td>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                    href="blog-management-edit-post.html"><i data-feather="edit"></i></a>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i
                                        data-feather="trash-2"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>Design Thinking Benefits Corporation Thought Leadership</td>
                            <td>17 Jun 2021</td>
                            <td>
                                <div class="badge bg-green-soft text-green">Published</div>
                            </td>
                            <td>Mahesh Kumar</td>
                            <td>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                    href="blog-management-edit-post.html"><i data-feather="edit"></i></a>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i
                                        data-feather="trash-2"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>Collaborative Consumption, Human-Centered Technology Thought Leader Systems</td>
                            <td>16 Jun 2021</td>
                            <td>
                                <div class="badge bg-green-soft text-green">Published</div>
                            </td>
                            <td>William Cole</td>
                            <td>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                    href="blog-management-edit-post.html"><i data-feather="edit"></i></a>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i
                                        data-feather="trash-2"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>Co-create, Empower - Moving the Needle on Investor Interests</td>
                            <td>14 Jun 2021</td>
                            <td>
                                <div class="badge bg-green-soft text-green">Published</div>
                            </td>
                            <td>Valerie Luna</td>
                            <td>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                    href="blog-management-edit-post.html"><i data-feather="edit"></i></a>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i
                                        data-feather="trash-2"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>Inclusive Shared Units of Analysis</td>
                            <td>13 Jun 2021</td>
                            <td>
                                <div class="badge bg-green-soft text-green">Published</div>
                            </td>
                            <td>Amy Love</td>
                            <td>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                    href="blog-management-edit-post.html"><i data-feather="edit"></i></a>
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
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables/datatables-simple-demo.js') }}"></script>
@endsection
