@extends('template.layouts.app')

@section('title', 'Charts')

@section('header')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="bar-chart"></i></div>
                            Charts
                        </h1>
                        <div class="page-header-subtitle">Interactive charts to display your data, powered by Chart.js,
                            customized for SB Admin Pro</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container-xl px-4 mt-n10">
        <!-- Area chart example-->
        <div class="card mb-4">
            <div class="card-header">Area Chart Example</div>
            <div class="card-body">
                <div class="chart-area"><canvas id="myAreaChart" width="100%" height="30"></canvas></div>
            </div>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <!-- Bar chart example-->
                <div class="card mb-4">
                    <div class="card-header">Bar Chart Example</div>
                    <div class="card-body">
                        <div class="chart-bar"><canvas id="myBarChart" width="100%" height="50"></canvas></div>
                    </div>
                    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- Pie chart example-->
                <div class="card mb-4">
                    <div class="card-header">Pie Chart Example</div>
                    <div class="card-body">
                        <div class="chart-pie"><canvas id="myPieChart" width="100%" height="50"></canvas></div>
                    </div>
                    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                </div>
            </div>
        </div>
        <!-- Third party docs message-->
        <div class="card card-icon mb-4">
            <div class="row g-0">
                <div class="col-auto card-icon-aside bg-primary"><i class="text-white-50" data-feather="alert-triangle"></i>
                </div>
                <div class="col">
                    <div class="card-body py-5">
                        <h5 class="card-title">Third-Party Documentation Available</h5>
                        <p class="card-text">Chart.js is a third party plugin that is used to generate the charts in this
                            template. The charts above have been customized to fit the style of the SB Admin Pro theme. For
                            further customization options, please visit the official Chart.js documentation.</p>
                        <a class="btn btn-primary btn-sm" href="https://www.chartjs.org/docs/2.9.4/" target="_blank">
                            <i class="me-1" data-feather="external-link"></i>
                            Visit Chart.js Docs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.3/chart.umd.js"
        integrity="sha512-wv0y1q2yUeK6D55tLrploHgbqz7ZuGB89rWPqmy6qOR9TmmzYO69YZYbGIYDmqmKG0GwOHQXlKwPyOnJ95intA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        
    <script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
    <script src="{{ asset('assets/demo/chart-pie-demo.js') }}"></script>
@endsection
