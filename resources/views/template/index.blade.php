@extends('template.layouts.app')

@section('title', 'Overview')

@section('header')
    <header class="py-10 mb-4 bg-gradient-primary-to-secondary">
        <div class="container-xl px-4">
            <div class="text-center">
                <h1 class="text-white">Welcome to SB Admin Pro</h1>
                <p class="lead mb-0 text-white-50">A professionally designed admin panel template built
                    with Bootstrap 5</p>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container-xl px-4">
        <h2 class="mt-5 mb-0">Dashboards</h2>
        <p>Three dashboard examples to get you started!</p>
        <hr class="mt-0 mb-4" />
        <div class="row">
            <div class="col-md-6 col-xl-4 mb-4 mb-xl-0">
                <a class="d-block lift rounded overflow-hidden mb-2" href="{{ route('template.dashboards.defaults') }}"><img
                        class="img-fluid"
                        src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/dashboards/default.png"
                        alt="..." /></a>
                <div class="text-center small">Default Dashboard</div>
            </div>
            <div class="col-md-6 col-xl-4 mb-4 mb-xl-0">
                <a class="d-block lift rounded overflow-hidden mb-2" href="{{ route('template.dashboards.affiliate') }}"><img
                        class="img-fluid"
                        src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/dashboards/affiliate.png"
                        alt="..." /></a>
                <div class="text-center small">Affiliate Dashboard</div>
            </div>
            <div class="col-md-6 col-xl-4">
                <a class="d-block lift rounded overflow-hidden mb-2"
                    href="{{ route('template.dashboards.multiporpose') }}"><img class="img-fluid"
                        src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/dashboards/multipurpose.png"
                        alt="..." /></a>
                <div class="text-center small">Multipurpose Dashboard</div>
            </div>
        </div>
        <h2 class="mt-5 mb-0">App Pages</h2>
        <p>App pages to cover common use pages to help build your app!</p>
        <hr class="mt-0 mb-4" />
        <div class="row">
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <a class="d-block lift rounded overflow-hidden mb-2"
                    href="{{ route('template.pages.accounts.billing') }}"><img class="img-fluid"
                        src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/account-billing.png"
                        alt="..." /></a>
                <div class="text-center small">Account - Billing</div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <a class="d-block lift rounded overflow-hidden mb-2"
                    href="{{ route('template.pages.accounts.notifications') }}"><img class="img-fluid"
                        src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/account-notifications.png"
                        alt="..." /></a>
                <div class="text-center small">Account - Notifications</div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <a class="d-block lift rounded overflow-hidden mb-2"
                    href="{{ route('template.pages.accounts.profile') }}"><img class="img-fluid"
                        src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/account-profile.png"
                        alt="..." /></a>
                <div class="text-center small">Account - Profile</div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <a class="d-block lift rounded overflow-hidden mb-2"
                    href="{{ route('template.pages.accounts.security') }}"><img class="img-fluid"
                        src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/account-security.png"
                        alt="..." /></a>
                <div class="text-center small">Account - Security</div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <a class="d-block lift rounded overflow-hidden mb-2"
                    href="{{ route('template.pages.authentication.basic.login') }}"><img class="img-fluid"
                        src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/auth-login-basic.png"
                        alt="..." /></a>
                <div class="text-center small">Auth - Login</div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <a class="d-block lift rounded overflow-hidden mb-2"
                    href="{{ route('template.pages.authentication.social.login') }}"><img class="img-fluid"
                        src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/auth-login-social.png"
                        alt="..." /></a>
                <div class="text-center small">Auth - Login (Social)</div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <a class="d-block lift rounded overflow-hidden mb-2"
                    href="{{ route('template.flows.multitenants_registration.select') }}"><img class="img-fluid"
                        src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/auth-mutli-tenant.png"
                        alt="..." /></a>
                <div class="text-center small">Auth - Multi Tenant</div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <a class="d-block lift rounded overflow-hidden mb-2"
                    href="{{ route('template.pages.authentication.basic.forgot_password') }}"><img class="img-fluid"
                        src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/auth-password-basic.png"
                        alt="..." /></a>
                <div class="text-center small">Auth - Password</div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <a class="d-block lift rounded overflow-hidden mb-2"
                    href="{{ route('template.pages.authentication.social.forgot_password') }}"><img class="img-fluid"
                        src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/auth-password-social.png"
                        alt="..." /></a>
                <div class="text-center small">Auth - Password (Social)</div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <a class="d-block lift rounded overflow-hidden mb-2"
                    href="{{ route('template.pages.authentication.basic.register') }}"><img class="img-fluid"
                        src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/auth-register-basic.png"
                        alt="..." /></a>
                <div class="text-center small">Auth - Register</div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <a class="d-block lift rounded overflow-hidden mb-2"
                    href="{{ route('template.pages.authentication.social.register') }}"><img class="img-fluid"
                        src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/auth-register-social.png"
                        alt="..." /></a>
                <div class="text-center small">Auth - Register (Social)</div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <a class="d-block lift rounded overflow-hidden mb-2" href="{{ route('template.pages.invoice') }}"><img
                        class="img-fluid"
                        src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/invoice.png"
                        alt="..." /></a>
                <div class="text-center small">Invoice</div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <a class="d-block lift rounded overflow-hidden mb-2"
                    href="{{ route('template.applications.knowledge_base.article') }}"><img class="img-fluid"
                        src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/knowledgebase-article.png"
                        alt="..." /></a>
                <div class="text-center small">Knowledgebase - Article</div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <a class="d-block lift rounded overflow-hidden mb-2"
                    href="{{ route('template.applications.knowledge_base.category') }}"><img class="img-fluid"
                        src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/knowledgebase-category.png"
                        alt="..." /></a>
                <div class="text-center small">Knowledgebase - Category</div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <a class="d-block lift rounded overflow-hidden mb-2"
                    href="{{ route('template.applications.knowledge_base.home1') }}"><img class="img-fluid"
                        src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/knowledgebase-home-1.png"
                        alt="..." /></a>
                <div class="text-center small">Knowledgebase - Home 1</div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <a class="d-block lift rounded overflow-hidden mb-2"
                    href="{{ route('template.applications.knowledge_base.home2') }}"><img class="img-fluid"
                        src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/knowledgebase-home-2.png"
                        alt="..." /></a>
                <div class="text-center small">Knowledgebase - Home 2</div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <a class="d-block lift rounded overflow-hidden mb-2" href="{{ route('template.pages.pricing') }}"><img
                        class="img-fluid"
                        src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/pricing.png"
                        alt="..." /></a>
                <div class="text-center small">Pricing</div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <a class="d-block lift rounded overflow-hidden mb-2" href="{{ route('template.flows.wizard') }}"><img
                        class="img-fluid"
                        src="https://assets.startbootstrap.com/img/screenshots-product-pages/sb-admin-pro/pages/wizard.png"
                        alt="..." /></a>
                <div class="text-center small">Wizard</div>
            </div>
        </div>
        <h2 class="mt-5 mb-0">Starter Layouts</h2>
        <p>Layouts for creating new pages within your project!</p>
        <hr class="mt-0 mb-4" />
        <div class="row">
            <div class="col-sm-6 col-md-4 mb-4">
                <div class="small mb-1">Navigation</div>
                <div class="list-group mb-4">
                    <a class="list-group-item list-group-item-action p-3"
                        href="{{ route('template.layout.navigation.static') }}">
                        <div class="d-flex align-items-center justify-content-between">
                            Static Sidenav
                            <i class="text-muted" data-feather="arrow-right"></i>
                        </div>
                    </a>
                    <a class="list-group-item list-group-item-action p-3"
                        href="{{ route('template.layout.navigation.dark') }}">
                        <div class="d-flex align-items-center justify-content-between">
                            Dark Sidenav
                            <i class="text-muted" data-feather="arrow-right"></i>
                        </div>
                    </a>
                    <a class="list-group-item list-group-item-action p-3"
                        href="{{ route('template.layout.navigation.rtl') }}">
                        <div class="d-flex align-items-center justify-content-between">
                            RTL Layout
                            <i class="text-muted" data-feather="arrow-right"></i>
                        </div>
                    </a>
                </div>
                <div class="small mb-1">Container Options</div>
                <div class="list-group">
                    <a class="list-group-item list-group-item-action p-3"
                        href="{{ route('template.layout.container_options.boxed') }}">
                        <div class="d-flex align-items-center justify-content-between">
                            Boxed Layouts
                            <i class="text-muted" data-feather="arrow-right"></i>
                        </div>
                    </a>
                    <a class="list-group-item list-group-item-action p-3"
                        href="{{ route('template.layout.container_options.fluid') }}">
                        <div class="d-flex align-items-center justify-content-between">
                            Fluid Layout
                            <i class="text-muted" data-feather="arrow-right"></i>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 mb-4">
                <div class="small mb-1">Page Headers</div>
                <div class="list-group">
                    <a class="list-group-item list-group-item-action p-3"
                        href="{{ route('template.layout.page_headers.simplified') }}">
                        <div class="d-flex align-items-center justify-content-between">
                            Simplified
                            <i class="text-muted" data-feather="arrow-right"></i>
                        </div>
                    </a>
                    <a class="list-group-item list-group-item-action p-3"
                        href="{{ route('template.layout.page_headers.compact') }}">
                        <div class="d-flex align-items-center justify-content-between">
                            Compact
                            <i class="text-muted" data-feather="arrow-right"></i>
                        </div>
                    </a>
                    <a class="list-group-item list-group-item-action p-3"
                        href="{{ route('template.layout.page_headers.content_overlap') }}">
                        <div class="d-flex align-items-center justify-content-between">
                            Content Overlap
                            <i class="text-muted" data-feather="arrow-right"></i>
                        </div>
                    </a>
                    <a class="list-group-item list-group-item-action p-3"
                        href="{{ route('template.layout.page_headers.breadcrumbs') }}">
                        <div class="d-flex align-items-center justify-content-between">
                            Breadcrumbs
                            <i class="text-muted" data-feather="arrow-right"></i>
                        </div>
                    </a>
                    <a class="list-group-item list-group-item-action p-3"
                        href="{{ route('template.layout.page_headers.light') }}">
                        <div class="d-flex align-items-center justify-content-between">
                            Light
                            <i class="text-muted" data-feather="arrow-right"></i>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 mb-4">
                <div class="small mb-1">Starter Layouts</div>
                <div class="list-group mb-4">
                    <a class="list-group-item list-group-item-action p-3"
                        href="{{ route('template.layout.stater.default') }}">
                        <div class="d-flex align-items-center justify-content-between">
                            Default
                            <i class="text-muted" data-feather="arrow-right"></i>
                        </div>
                    </a>
                    <a class="list-group-item list-group-item-action p-3"
                        href="{{ route('template.layout.stater.minimal') }}">
                        <div class="d-flex align-items-center justify-content-between">
                            Minimal
                            <i class="text-muted" data-feather="arrow-right"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
