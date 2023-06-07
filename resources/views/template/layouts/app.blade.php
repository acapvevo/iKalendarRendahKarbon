@extends('layouts.app')

@php
    $home = route('template.index');
@endphp

@section('apps', 'SB Admin Pro')

@section('alerts')
    <!-- Example Alert 1-->
    <a class="dropdown-item dropdown-notifications-item" href="#!">
        <div class="dropdown-notifications-item-icon bg-warning"><i data-feather="activity"></i></div>
        <div class="dropdown-notifications-item-content">
            <div class="dropdown-notifications-item-content-details">December 29, 2021</div>
            <div class="dropdown-notifications-item-content-text">This is an alert message. It's
                nothing serious, but it requires your attention.</div>
        </div>
    </a>
    <!-- Example Alert 2-->
    <a class="dropdown-item dropdown-notifications-item" href="#!">
        <div class="dropdown-notifications-item-icon bg-info"><i data-feather="bar-chart"></i></div>
        <div class="dropdown-notifications-item-content">
            <div class="dropdown-notifications-item-content-details">December 22, 2021</div>
            <div class="dropdown-notifications-item-content-text">A new monthly report is ready. Click
                here to view!</div>
        </div>
    </a>
    <!-- Example Alert 3-->
    <a class="dropdown-item dropdown-notifications-item" href="#!">
        <div class="dropdown-notifications-item-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="dropdown-notifications-item-content">
            <div class="dropdown-notifications-item-content-details">December 8, 2021</div>
            <div class="dropdown-notifications-item-content-text">Critical system failure, systems
                shutting down.</div>
        </div>
    </a>
    <!-- Example Alert 4-->
    <a class="dropdown-item dropdown-notifications-item" href="#!">
        <div class="dropdown-notifications-item-icon bg-success"><i data-feather="user-plus"></i>
        </div>
        <div class="dropdown-notifications-item-content">
            <div class="dropdown-notifications-item-content-details">December 2, 2021</div>
            <div class="dropdown-notifications-item-content-text">New user request. Woody has requested
                access to the organization.</div>
        </div>
    </a>
@endsection

@section('messages')
    <!-- Example Message 1  -->
    <a class="dropdown-item dropdown-notifications-item" href="#!">
        <img class="dropdown-notifications-item-img" src="{{ asset('assets/img/illustrations/profiles/profile-2.png') }}" />
        <div class="dropdown-notifications-item-content">
            <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet,
                consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
            <div class="dropdown-notifications-item-content-details">Thomas Wilcox · 58m</div>
        </div>
    </a>
    <!-- Example Message 2-->
    <a class="dropdown-item dropdown-notifications-item" href="#!">
        <img class="dropdown-notifications-item-img" src="{{ asset('assets/img/illustrations/profiles/profile-3.png') }}" />
        <div class="dropdown-notifications-item-content">
            <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet,
                consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
            <div class="dropdown-notifications-item-content-details">Emily Fowler · 2d</div>
        </div>
    </a>
    <!-- Example Message 3-->
    <a class="dropdown-item dropdown-notifications-item" href="#!">
        <img class="dropdown-notifications-item-img" src="{{ asset('assets/img/illustrations/profiles/profile-4.png') }}" />
        <div class="dropdown-notifications-item-content">
            <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet,
                consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
            <div class="dropdown-notifications-item-content-details">Marshall Rosencrantz · 3d</div>
        </div>
    </a>
    <!-- Example Message 4-->
    <a class="dropdown-item dropdown-notifications-item" href="#!">
        <img class="dropdown-notifications-item-img" src="{{ asset('assets/img/illustrations/profiles/profile-5.png') }}" />
        <div class="dropdown-notifications-item-content">
            <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet,
                consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
            <div class="dropdown-notifications-item-content-details">Colby Newton · 3d</div>
        </div>
    </a>
@endsection

@section('name', 'Valerie Luna')
@section('email', 'vluna@aol.com')

@section('topmenu')
    <a class="dropdown-item" href="#!">
        <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
        Account
    </a>
    <a class="dropdown-item" href="#!">
        <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
        Logout
    </a>
@endsection

@section('sidemenu')
    <!-- Sidenav Menu Heading (Core)-->
    <div class="sidenav-menu-heading">Core</div>
    <!-- Sidenav Accordion (Dashboard)-->
    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseDashboards"
        aria-expanded="false" aria-controls="collapseDashboards">
        <div class="nav-link-icon"><i data-feather="activity"></i></div>
        Dashboards
        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseDashboards" data-bs-parent="#accordionSidenav">
        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
            <a class="nav-link" href="{{ route('template.dashboards.defaults') }}">
                Default
                <span class="badge bg-primary-soft text-primary ms-auto">Updated</span>
            </a>
            <a class="nav-link" href="{{ route('template.dashboards.multiporpose') }}">Multipurpose</a>
            <a class="nav-link" href="{{ route('template.dashboards.affiliate') }}">Affiliate</a>
        </nav>
    </div>
    <!-- Sidenav Heading (Custom)-->
    <div class="sidenav-menu-heading">Custom</div>
    <!-- Sidenav Accordion (Pages)-->
    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsePages"
        aria-expanded="false" aria-controls="collapsePages">
        <div class="nav-link-icon"><i data-feather="grid"></i></div>
        Pages
        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapsePages" data-bs-parent="#accordionSidenav">
        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPagesMenu">
            <!-- Nested Sidenav Accordion (Pages -> Account)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                data-bs-target="#pagesCollapseAccount" aria-expanded="false" aria-controls="pagesCollapseAccount">
                Account
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="pagesCollapseAccount" data-bs-parent="#accordionSidenavPagesMenu">
                <nav class="sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('template.pages.accounts.profile') }}">Profile</a>
                    <a class="nav-link" href="{{ route('template.pages.accounts.billing') }}">Billing</a>
                    <a class="nav-link" href="{{ route('template.pages.accounts.security') }}">Security</a>
                    <a class="nav-link" href="{{ route('template.pages.accounts.notifications') }}">Notifications</a>
                </nav>
            </div>
            <!-- Nested Sidenav Accordion (Pages -> Authentication)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                Authentication
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="pagesCollapseAuth" data-bs-parent="#accordionSidenavPagesMenu">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPagesAuth">
                    <!-- Nested Sidenav Accordion (Pages -> Authentication -> Basic)-->
                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                        data-bs-target="#pagesCollapseAuthBasic" aria-expanded="false"
                        aria-controls="pagesCollapseAuthBasic">
                        Basic
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i>
                        </div>
                    </a>
                    <div class="collapse" id="pagesCollapseAuthBasic" data-bs-parent="#accordionSidenavPagesAuth">
                        <nav class="sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('template.pages.authentication.basic.login') }}">Login</a>
                            <a class="nav-link"
                                href="{{ route('template.pages.authentication.basic.register') }}">Register</a>
                            <a class="nav-link"
                                href="{{ route('template.pages.authentication.basic.forgot_password') }}">Forgot
                                Password</a>
                        </nav>
                    </div>
                    <!-- Nested Sidenav Accordion (Pages -> Authentication -> Social)-->
                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                        data-bs-target="#pagesCollapseAuthSocial" aria-expanded="false"
                        aria-controls="pagesCollapseAuthSocial">
                        Social
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i>
                        </div>
                    </a>
                    <div class="collapse" id="pagesCollapseAuthSocial" data-bs-parent="#accordionSidenavPagesAuth">
                        <nav class="sidenav-menu-nested nav">
                            <a class="nav-link"
                                href="{{ route('template.pages.authentication.social.login') }}">Login</a>
                            <a class="nav-link"
                                href="{{ route('template.pages.authentication.social.register') }}">Register</a>
                            <a class="nav-link"
                                href="{{ route('template.pages.authentication.social.forgot_password') }}">Forgot
                                Password</a>
                        </nav>
                    </div>
                </nav>
            </div>
            <!-- Nested Sidenav Accordion (Pages -> Error)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                Error
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="pagesCollapseError" data-bs-parent="#accordionSidenavPagesMenu">
                <nav class="sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('template.pages.error.400') }}">400 Error</a>
                    <a class="nav-link" href="{{ route('template.pages.error.401') }}">401 Error</a>
                    <a class="nav-link" href="{{ route('template.pages.error.403') }}">403 Error</a>
                    <a class="nav-link" href="{{ route('template.pages.error.404v1') }}">404 Error 1</a>
                    <a class="nav-link" href="{{ route('template.pages.error.404v2') }}">404 Error 2</a>
                    <a class="nav-link" href="{{ route('template.pages.error.500') }}">500 Error</a>
                    <a class="nav-link" href="{{ route('template.pages.error.503') }}">503 Error</a>
                    <a class="nav-link" href="{{ route('template.pages.error.504') }}">504 Error</a>
                </nav>
            </div>
            <a class="nav-link" href="{{ route('template.pages.pricing') }}">Pricing</a>
            <a class="nav-link" href="{{ route('template.pages.invoice') }}">Invoice</a>
        </nav>
    </div>
    <!-- Sidenav Accordion (Applications)-->
    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseApps"
        aria-expanded="false" aria-controls="collapseApps">
        <div class="nav-link-icon"><i data-feather="globe"></i></div>
        Applications
        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseApps" data-bs-parent="#accordionSidenav">
        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavAppsMenu">
            <!-- Nested Sidenav Accordion (Apps -> Knowledge Base)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                data-bs-target="#appsCollapseKnowledgeBase" aria-expanded="false"
                aria-controls="appsCollapseKnowledgeBase">
                Knowledge Base
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="appsCollapseKnowledgeBase" data-bs-parent="#accordionSidenavAppsMenu">
                <nav class="sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('template.applications.knowledge_base.home1') }}">Home 1</a>
                    <a class="nav-link" href="{{ route('template.applications.knowledge_base.home2') }}">Home 2</a>
                    <a class="nav-link" href="{{ route('template.applications.knowledge_base.category') }}">Category</a>
                    <a class="nav-link" href="{{ route('template.applications.knowledge_base.article') }}">Article</a>
                </nav>
            </div>
            <!-- Nested Sidenav Accordion (Apps -> User Management)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                data-bs-target="#appsCollapseUserManagement" aria-expanded="false"
                aria-controls="appsCollapseUserManagement">
                User Management
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="appsCollapseUserManagement" data-bs-parent="#accordionSidenavAppsMenu">
                <nav class="sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('template.applications.user_management.list') }}">Users List</a>
                    <a class="nav-link" href="{{ route('template.applications.user_management.edit') }}">Edit User</a>
                    <a class="nav-link" href="{{ route('template.applications.user_management.add') }}">Add User</a>
                    <a class="nav-link" href="{{ route('template.applications.user_management.groups_list') }}">Groups
                        List</a>
                    <a class="nav-link"
                        href="{{ route('template.applications.user_management.organization_details') }}">Organization
                        Details</a>
                </nav>
            </div>
            <!-- Nested Sidenav Accordion (Apps -> Posts Management)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                data-bs-target="#appsCollapsePostsManagement" aria-expanded="false"
                aria-controls="appsCollapsePostsManagement">
                Posts Management
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="appsCollapsePostsManagement" data-bs-parent="#accordionSidenavAppsMenu">
                <nav class="sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('template.applications.posts_management.list') }}">Posts List</a>
                    <a class="nav-link" href="{{ route('template.applications.posts_management.create') }}">Create
                        Post</a>
                    <a class="nav-link" href="{{ route('template.applications.posts_management.edit') }}">Edit Post</a>
                    <a class="nav-link" href="{{ route('template.applications.posts_management.admins') }}">Posts
                        Admin</a>
                </nav>
            </div>
        </nav>
    </div>
    <!-- Sidenav Accordion (Flows)-->
    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseFlows"
        aria-expanded="false" aria-controls="collapseFlows">
        <div class="nav-link-icon"><i data-feather="repeat"></i></div>
        Flows
        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseFlows" data-bs-parent="#accordionSidenav">
        <nav class="sidenav-menu-nested nav">
            <a class="nav-link" href="{{ route('template.flows.multitenants_registration.select') }}">Multi-Tenant
                Registration</a>
            <a class="nav-link" href="{{ route('template.flows.wizard') }}">Wizard</a>
        </nav>
    </div>
    <!-- Sidenav Heading (UI Toolkit)-->
    <div class="sidenav-menu-heading">UI Toolkit</div>
    <!-- Sidenav Accordion (Layout)-->
    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
        aria-expanded="false" aria-controls="collapseLayouts">
        <div class="nav-link-icon"><i data-feather="layout"></i></div>
        Layout
        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseLayouts" data-bs-parent="#accordionSidenav">
        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayout">
            <!-- Nested Sidenav Accordion (Layout -> Navigation)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                data-bs-target="#collapseLayoutSidenavVariations" aria-expanded="false"
                aria-controls="collapseLayoutSidenavVariations">
                Navigation
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayoutSidenavVariations" data-bs-parent="#accordionSidenavLayout">
                <nav class="sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('template.layout.navigation.static') }}">Static Sidenav</a>
                    <a class="nav-link" href="{{ route('template.layout.navigation.dark') }}">Dark Sidenav</a>
                    <a class="nav-link" href="{{ route('template.layout.navigation.rtl') }}">RTL Layout</a>
                </nav>
            </div>
            <!-- Nested Sidenav Accordion (Layout -> Container Options)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                data-bs-target="#collapseLayoutContainers" aria-expanded="false"
                aria-controls="collapseLayoutContainers">
                Container Options
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayoutContainers" data-bs-parent="#accordionSidenavLayout">
                <nav class="sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('template.layout.container_options.boxed') }}">Boxed Layout</a>
                    <a class="nav-link" href="{{ route('template.layout.container_options.fluid') }}">Fluid Layout</a>
                </nav>
            </div>
            <!-- Nested Sidenav Accordion (Layout -> Page Headers)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                data-bs-target="#collapseLayoutsPageHeaders" aria-expanded="false"
                aria-controls="collapseLayoutsPageHeaders">
                Page Headers
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayoutsPageHeaders" data-bs-parent="#accordionSidenavLayout">
                <nav class="sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('template.layout.page_headers.simplified') }}">Simplified</a>
                    <a class="nav-link" href="{{ route('template.layout.page_headers.compact') }}">Compact</a>
                    <a class="nav-link" href="{{ route('template.layout.page_headers.content_overlap') }}">Content
                        Overlap</a>
                    <a class="nav-link" href="{{ route('template.layout.page_headers.breadcrumbs') }}">Breadcrumbs</a>
                    <a class="nav-link" href="{{ route('template.layout.page_headers.light') }}">Light</a>
                </nav>
            </div>
            <!-- Nested Sidenav Accordion (Layout -> Starter Layouts)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                data-bs-target="#collapseLayoutsStarterTemplates" aria-expanded="false"
                aria-controls="collapseLayoutsStarterTemplates">
                Starter Layouts
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayoutsStarterTemplates" data-bs-parent="#accordionSidenavLayout">
                <nav class="sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('template.layout.stater.default') }}">Default</a>
                    <a class="nav-link" href="{{ route('template.layout.stater.minimal') }}">Minimal</a>
                </nav>
            </div>
        </nav>
    </div>
    <!-- Sidenav Accordion (Components)-->
    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
        data-bs-target="#collapseComponents" aria-expanded="false" aria-controls="collapseComponents">
        <div class="nav-link-icon"><i data-feather="package"></i></div>
        Components
        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseComponents" data-bs-parent="#accordionSidenav">
        <nav class="sidenav-menu-nested nav">
            <a class="nav-link" href="{{ route('template.components.alerts') }}">Alerts</a>
            <a class="nav-link" href="{{ route('template.components.avatars') }}">Avatars</a>
            <a class="nav-link" href="{{ route('template.components.badges') }}">Badges</a>
            <a class="nav-link" href="{{ route('template.components.buttons') }}">Buttons</a>
            <a class="nav-link" href="{{ route('template.components.cards') }}">
                Cards
                <span class="badge bg-primary-soft text-primary ms-auto">Updated</span>
            </a>
            <a class="nav-link" href="{{ route('template.components.dropdowns') }}">Dropdowns</a>
            <a class="nav-link" href="{{ route('template.components.forms') }}">
                Forms
                <span class="badge bg-primary-soft text-primary ms-auto">Updated</span>
            </a>
            <a class="nav-link" href="{{ route('template.components.modals') }}">Modals</a>
            <a class="nav-link" href="{{ route('template.components.navigation') }}">Navigation</a>
            <a class="nav-link" href="{{ route('template.components.progress') }}">Progress</a>
            <a class="nav-link" href="{{ route('template.components.step') }}">Step</a>
            <a class="nav-link" href="{{ route('template.components.timeline') }}">Timeline</a>
            <a class="nav-link" href="{{ route('template.components.toasts') }}">Toasts</a>
            <a class="nav-link" href="{{ route('template.components.tooltips') }}">Tooltips</a>
        </nav>
    </div>
    <!-- Sidenav Accordion (Utilities)-->
    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
        data-bs-target="#collapseUtilities" aria-expanded="false" aria-controls="collapseUtilities">
        <div class="nav-link-icon"><i data-feather="tool"></i></div>
        Utilities
        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseUtilities" data-bs-parent="#accordionSidenav">
        <nav class="sidenav-menu-nested nav">
            <a class="nav-link" href="{{ route('template.utilities.animations') }}">Animations</a>
            <a class="nav-link" href="{{ route('template.utilities.background') }}">Background</a>
            <a class="nav-link" href="{{ route('template.utilities.borders') }}">Borders</a>
            <a class="nav-link" href="{{ route('template.utilities.lift') }}">Lift</a>
            <a class="nav-link" href="{{ route('template.utilities.shadows') }}">Shadows</a>
            <a class="nav-link" href="{{ route('template.utilities.typography') }}">Typography</a>
        </nav>
    </div>
    <!-- Sidenav Heading (Addons)-->
    <div class="sidenav-menu-heading">Plugins</div>
    <!-- Sidenav Link (Charts)-->
    <a class="nav-link" href="{{ route('template.charts') }}">
        <div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
        Charts
    </a>
    <!-- Sidenav Link (Tables)-->
    <a class="nav-link" href="{{ route('template.tables') }}">
        <div class="nav-link-icon"><i data-feather="filter"></i></div>
        Tables
    </a>
@endsection
