@extends('template.layouts.app')

@section('title', 'Pricing')

@section('header')
@endsection

@section('content')
    <div class="container-xl px-4">
        <div class="text-center my-10">
            <h1 class="text-primary mb-2 display-6 fw-bold">Pricing Plans</h1>
            <p class="lead mb-0">Pricing built for any business. No surprises, no hassle.</p>
        </div>
        <!-- Detailed pricing example-->
        <div class="pricing-detailed">
            <div class="row align-items-center g-0">
                <!-- Detailed pricing column 1-->
                <div class="col-lg-6 z-1 mb-4 mb-lg-0">
                    <div class="card text-center border-0">
                        <div class="card-header bg-transparent justify-content-center py-4">
                            <h5 class="text-primary mb-0">Standard</h5>
                        </div>
                        <div class="card-body p-5">
                            <p class="lead mb-4">One easy to understand pricing plan for all of our users! Get complete
                                access to all of our features.</p>
                            <div class="mb-4">
                                <span class="display-4 fw-bold text-dark">$9</span>
                                <span>/mo</span>
                            </div>
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-center justify-content-center mb-3">
                                    <i class="text-primary me-2" data-feather="check-circle"></i>
                                    Unlimited access to all of our products
                                </li>
                                <li class="d-flex align-items-center justify-content-center mb-3">
                                    <i class="text-primary me-2" data-feather="check-circle"></i>
                                    No setup fees or any hidden fees
                                </li>
                                <li class="d-flex align-items-center justify-content-center">
                                    <i class="text-primary me-2" data-feather="check-circle"></i>
                                    Dedicated customer support
                                </li>
                            </ul>
                        </div>
                        <a class="card-footer d-flex align-items-center justify-content-center" href="#!">
                            Start now
                            <i class="ms-2" data-feather="arrow-right"></i>
                        </a>
                    </div>
                </div>
                <!-- Detailed pricing column 2-->
                <div class="col-lg-6">
                    <div class="card bg-dark text-center pricing-detailed-behind">
                        <div class="card-header justify-content-center py-4">
                            <h5 class="mb-0 text-white">Custom</h5>
                        </div>
                        <div class="card-body text-white-50 p-5">Need something more? We offer customized, enterprise level
                            plans for specific implementations. Contact our sales team to learn more about custom licensing!
                        </div>
                        <a class="card-footer bg-gray-800 text-white d-flex align-items-center justify-content-center"
                            href="#!">
                            Contact sales
                            <i class="ms-2" data-feather="arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-10" />
    <div class="container-xl px-4">
        <div class="text-center my-10">
            <h1 class="text-primary mb-2">Pricing built for your business.</h1>
            <p class="lead">Start out small and upgrade as you grow. No surprises, no hassle.</p>
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input class="btn-check" id="btnMonthlyBilling" type="radio" name="btnradio" autocomplete="off" checked />
                <label class="btn btn-outline-primary" for="btnMonthlyBilling">Monthly Billing</label>
                <input class="btn-check" id="btnYearlyBilling" type="radio" name="btnradio" autocomplete="off" />
                <label class="btn btn-outline-primary" for="btnYearlyBilling">Yearly Billing</label>
            </div>
        </div>
        <!-- Pricing columns example-->
        <div class="pricing-columns">
            <div class="row justify-content-center">
                <!-- Pricing column 1-->
                <div class="col-xl-4 col-lg-6 mb-4 mb-xl-0">
                    <div class="card h-100">
                        <div class="card-header bg-transparent">
                            <span class="badge bg-primary-soft text-primary rounded-pill py-2 px-3 mb-2">Individual</span>
                            <div class="pricing-columns-price">
                                $9
                                <span>/month</span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <i class="text-primary me-2" data-feather="check-circle"></i>
                                    1 user account
                                </li>
                                <li class="list-group-item">
                                    <i class="text-primary me-2" data-feather="check-circle"></i>
                                    Remove ads
                                </li>
                                <li class="list-group-item">
                                    <i class="text-primary me-2" data-feather="check-circle"></i>
                                    Premium assets
                                </li>
                                <li class="list-group-item">
                                    <i class="text-primary me-2" data-feather="check-circle"></i>
                                    Saved projects
                                </li>
                            </ul>
                        </div>
                        <a class="card-footer d-flex align-items-center justify-content-between" href="#!">
                            Get started!
                            <i data-feather="arrow-right"></i>
                        </a>
                    </div>
                </div>
                <!-- Pricing column 2-->
                <div class="col-xl-4 col-lg-6 mb-4 mb-xl-0">
                    <div class="card h-100">
                        <div class="card-header bg-transparent">
                            <span class="badge bg-secondary-soft text-secondary rounded-pill py-2 px-3 mb-2">Team</span>
                            <div class="pricing-columns-price">
                                $39
                                <span>/month</span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <i class="text-secondary me-2" data-feather="check-circle"></i>
                                    Up to 5 user accounts
                                </li>
                                <li class="list-group-item">
                                    <i class="text-secondary me-2" data-feather="check-circle"></i>
                                    Remove ads
                                </li>
                                <li class="list-group-item">
                                    <i class="text-secondary me-2" data-feather="check-circle"></i>
                                    Premium assets
                                </li>
                                <li class="list-group-item">
                                    <i class="text-secondary me-2" data-feather="check-circle"></i>
                                    Saved projects
                                </li>
                                <li class="list-group-item">
                                    <i class="text-secondary me-2" data-feather="check-circle"></i>
                                    Team collaboration tools
                                </li>
                            </ul>
                        </div>
                        <a class="card-footer d-flex align-items-center justify-content-between text-secondary"
                            href="#!">
                            Get started!
                            <i data-feather="arrow-right"></i>
                        </a>
                    </div>
                </div>
                <!-- Pricing column 3-->
                <div class="col-xl-4 col-lg-6">
                    <div class="pricing-table">
                        <div class="card h-100">
                            <div class="card-header bg-transparent">
                                <span
                                    class="badge bg-success-soft text-success rounded-pill py-2 px-3 mb-2">Organization</span>
                                <div class="pricing-columns-price">
                                    $249
                                    <span>/month</span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <i class="text-success me-2" data-feather="check-circle"></i>
                                        Up to 50 user accounts
                                    </li>
                                    <li class="list-group-item">
                                        <i class="text-success me-2" data-feather="check-circle"></i>
                                        Remove ads
                                    </li>
                                    <li class="list-group-item">
                                        <i class="text-success me-2" data-feather="check-circle"></i>
                                        Premium assets
                                    </li>
                                    <li class="list-group-item">
                                        <i class="text-success me-2" data-feather="check-circle"></i>
                                        Saved projects
                                    </li>
                                    <li class="list-group-item">
                                        <i class="text-success me-2" data-feather="check-circle"></i>
                                        Team collaboration tools
                                    </li>
                                    <li class="list-group-item">
                                        <i class="text-success me-2" data-feather="check-circle"></i>
                                        Create teams &amp; groups
                                    </li>
                                    <li class="list-group-item">
                                        <i class="text-success me-2" data-feather="check-circle"></i>
                                        Priority customer support
                                    </li>
                                </ul>
                            </div>
                            <a class="card-footer d-flex align-items-center justify-content-between text-success"
                                href="#!">
                                Get started!
                                <i data-feather="arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-10" />
    <div class="container-xl px-4">
        <div class="text-center my-10">
            <h1 class="text-primary mb-2 display-6 fw-bold">Pricing Plans</h1>
            <p class="lead mb-0">Compare our pricing plans and pick what's right for you.</p>
        </div>
        <!-- Pricing table example-->
        <div class="card rounded-lg overflow-hidden mb-5">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr class="bg-dark text-white">
                                <th class="py-4" scope="col"></th>
                                <th class="py-4" scope="col">Individual</th>
                                <th class="py-4" scope="col">Team</th>
                                <th class="py-4" scope="col">Organization</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="p-3" scope="row">Pricing</th>
                                <td class="p-3 w-25" style="min-width: 12.5rem">
                                    <div class="text-dark mb-2">
                                        <span class="h1">$9</span>
                                        <span class="small text-muted fw-normal">/mo.</span>
                                    </div>
                                    <p class="small">A basic plan for new users and individuals.</p>
                                    <div class="d-grid"><button class="btn btn-primary" type="button">Choose
                                            Plan</button></div>
                                </td>
                                <td class="p-3 w-25" style="min-width: 12.5rem">
                                    <div class="text-dark mb-2">
                                        <span class="h1">$39</span>
                                        <span class="small text-muted fw-normal">/mo.</span>
                                    </div>
                                    <p class="small">Our most popular plan. with more features.</p>
                                    <div class="d-grid"><button class="btn btn-primary" type="button">Choose
                                            Plan</button></div>
                                </td>
                                <td class="p-3 w-25" style="min-width: 12.5rem">
                                    <div class="text-dark mb-2">
                                        <span class="h1">$249</span>
                                        <span class="small text-muted fw-normal">/mo.</span>
                                    </div>
                                    <p class="small">Our most advanced plan for enterpise users.</p>
                                    <div class="d-grid"><button class="btn btn-primary" type="button">Choose
                                            Plan</button></div>
                                </td>
                            </tr>
                            <tr class="bg-gray-100">
                                <th class="p-3" scope="row">User accounts</th>
                                <td class="p-3">1</td>
                                <td class="p-3">Up to 5</td>
                                <td class="p-3">Up to 50</td>
                            </tr>
                            <tr>
                                <th class="p-3" scope="row">Ad free</th>
                                <td class="p-3"><i class="fas fa-check text-green"></i></td>
                                <td class="p-3"><i class="fas fa-check text-green"></i></td>
                                <td class="p-3"><i class="fas fa-check text-green"></i></td>
                            </tr>
                            <tr class="bg-gray-100">
                                <th class="p-3" scope="row">Premium assets</th>
                                <td class="p-3"><i class="fas fa-check text-green"></i></td>
                                <td class="p-3"><i class="fas fa-check text-green"></i></td>
                                <td class="p-3"><i class="fas fa-check text-green"></i></td>
                            </tr>
                            <tr>
                                <th class="p-3" scope="row">Saved projects</th>
                                <td class="p-3"><i class="fas fa-check text-green"></i></td>
                                <td class="p-3"><i class="fas fa-check text-green"></i></td>
                                <td class="p-3"><i class="fas fa-check text-green"></i></td>
                            </tr>
                            <tr class="bg-gray-100">
                                <th class="p-3" scope="row">Team collaboration tools</th>
                                <td class="p-3"><i class="fas fa-xmark text-red"></i></td>
                                <td class="p-3"><i class="fas fa-check text-green"></i></td>
                                <td class="p-3"><i class="fas fa-check text-green"></i></td>
                            </tr>
                            <tr>
                                <th class="p-3" scope="row">Create teams &amp; groups</th>
                                <td class="p-3"><i class="fas fa-xmark text-red"></i></td>
                                <td class="p-3"><i class="fas fa-xmark text-red"></i></td>
                                <td class="p-3"><i class="fas fa-check text-green"></i></td>
                            </tr>
                            <tr class="bg-gray-100">
                                <th class="p-3" scope="row">Customer support</th>
                                <td class="p-3">Email only</td>
                                <td class="p-3">Email &amp; phone</td>
                                <td class="p-3">Dedicated account manager</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
