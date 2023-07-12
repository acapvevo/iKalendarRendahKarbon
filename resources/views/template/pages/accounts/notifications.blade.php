@extends('template.layouts.app')

@section('title', 'Account Settings - Security')

@section('styles')
@endsection

@section('header')
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            Account Settings - Notifications
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container-xl px-4 mt-4">
        <!-- Account page navigation-->
        <nav class="nav nav-borders">
            <a class="nav-link ms-0" href="{{ route('template.pages.accounts.profile') }}">Profile</a>
            <a class="nav-link" href="{{ route('template.pages.accounts.billing') }}">Billing</a>
            <a class="nav-link" href="{{ route('template.pages.accounts.security') }}">Security</a>
            <a class="nav-link active" href="{{ route('template.pages.accounts.notifications') }}">Notifications</a>
        </nav>
        <hr class="mt-0 mb-4" />
        <div class="row">
            <div class="col-lg-8">
                <!-- Email notifications preferences card-->
                <div class="card card-header-actions mb-4">
                    <div class="card-header">
                        Email Notifications
                        <div class="form-check form-switch">
                            <input class="form-check-input" id="flexSwitchCheckChecked" type="checkbox" checked />
                            <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                        </div>
                    </div>
                    <div class="card-body">
                        <form>
                            <!-- Form Group (default email)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="inputNotificationEmail">Default notification email</label>
                                <input class="form-control" id="inputNotificationEmail" type="email"
                                    value="name@example.com" disabled />
                            </div>
                            <!-- Form Group (email updates checkboxes)-->
                            <div class="mb-0">
                                <label class="small mb-2">Choose which types of email updates you receive</label>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" id="checkAccountChanges" type="checkbox" checked />
                                    <label class="form-check-label" for="checkAccountChanges">Changes made to your
                                        account</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" id="checkAccountGroups" type="checkbox" checked />
                                    <label class="form-check-label" for="checkAccountGroups">Changes are made to groups
                                        you're part of</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" id="checkProductUpdates" type="checkbox" checked />
                                    <label class="form-check-label" for="checkProductUpdates">Product updates for products
                                        you've purchased or starred</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" id="checkProductNew" type="checkbox" checked />
                                    <label class="form-check-label" for="checkProductNew">Information on new products and
                                        services</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" id="checkPromotional" type="checkbox" />
                                    <label class="form-check-label" for="checkPromotional">Marketing and promotional
                                        offers</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" id="checkSecurity" type="checkbox" checked disabled />
                                    <label class="form-check-label" for="checkSecurity">Security alerts</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- SMS push notifications card-->
                <div class="card card-header-actions mb-4">
                    <div class="card-header">
                        Push Notifications
                        <div class="form-check form-switch">
                            <input class="form-check-input" id="smsToggleSwitch" type="checkbox" checked />
                            <label class="form-check-label" for="smsToggleSwitch"></label>
                        </div>
                    </div>
                    <div class="card-body">
                        <form>
                            <!-- Form Group (default SMS number)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="inputNotificationSms">Default SMS number</label>
                                <input class="form-control" id="inputNotificationSms" type="tel" value="123-456-7890"
                                    disabled />
                            </div>
                            <!-- Form Group (SMS updates checkboxes)-->
                            <div class="mb-0">
                                <label class="small mb-2">Choose which types of push notifications you receive</label>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" id="checkSmsComment" type="checkbox" checked />
                                    <label class="form-check-label" for="checkSmsComment">Someone comments on your
                                        post</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" id="checkSmsShare" type="checkbox" />
                                    <label class="form-check-label" for="checkSmsShare">Someone shares your post</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" id="checkSmsFollow" type="checkbox" checked />
                                    <label class="form-check-label" for="checkSmsFollow">A user follows your
                                        account</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" id="checkSmsGroup" type="checkbox" />
                                    <label class="form-check-label" for="checkSmsGroup">New posts are made in groups
                                        you're part of</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" id="checkSmsPrivateMessage" type="checkbox"
                                        checked />
                                    <label class="form-check-label" for="checkSmsPrivateMessage">You receive a private
                                        message</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Notifications preferences card-->
                <div class="card">
                    <div class="card-header">Notification Preferences</div>
                    <div class="card-body">
                        <form>
                            <!-- Form Group (notification preference checkboxes)-->
                            <div class="form-check mb-2">
                                <input class="form-check-input" id="checkAutoGroup" type="checkbox" checked />
                                <label class="form-check-label" for="checkAutoGroup">Automatically subscribe to group
                                    notifications</label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" id="checkAutoProduct" type="checkbox" />
                                <label class="form-check-label" for="checkAutoProduct">Automatically subscribe to new
                                    product notifications</label>
                            </div>
                            <!-- Submit button-->
                            <button class="btn btn-danger-soft text-danger">Unsubscribe from all notifications</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection