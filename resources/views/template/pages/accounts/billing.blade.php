@extends('template.layouts.app')

@section('title', 'Account Settings - Billing')

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
                            Account Settings - Billing
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
        <a class="nav-link ms-0" href="account-profile.html">Profile</a>
        <a class="nav-link" href="account-billing.html">Billing</a>
        <a class="nav-link active" href="account-security.html">Security</a>
        <a class="nav-link" href="account-notifications.html">Notifications</a>
    </nav>
    <hr class="mt-0 mb-4" />
    <div class="row">
        <div class="col-lg-8">
            <!-- Change password card-->
            <div class="card mb-4">
                <div class="card-header">Change Password</div>
                <div class="card-body">
                    <form>
                        <!-- Form Group (current password)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="currentPassword">Current Password</label>
                            <input class="form-control" id="currentPassword" type="password" placeholder="Enter current password" />
                        </div>
                        <!-- Form Group (new password)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="newPassword">New Password</label>
                            <input class="form-control" id="newPassword" type="password" placeholder="Enter new password" />
                        </div>
                        <!-- Form Group (confirm password)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="confirmPassword">Confirm Password</label>
                            <input class="form-control" id="confirmPassword" type="password" placeholder="Confirm new password" />
                        </div>
                        <button class="btn btn-primary" type="button">Save</button>
                    </form>
                </div>
            </div>
            <!-- Security preferences card-->
            <div class="card mb-4">
                <div class="card-header">Security Preferences</div>
                <div class="card-body">
                    <!-- Account privacy optinos-->
                    <h5 class="mb-1">Account Privacy</h5>
                    <p class="small text-muted">By setting your account to private, your profile information and posts will not be visible to users outside of your user groups.</p>
                    <form>
                        <div class="form-check">
                            <input class="form-check-input" id="radioPrivacy1" type="radio" name="radioPrivacy" checked />
                            <label class="form-check-label" for="radioPrivacy1">Public (posts are available to all users)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="radioPrivacy2" type="radio" name="radioPrivacy" />
                            <label class="form-check-label" for="radioPrivacy2">Private (posts are available to only users in your groups)</label>
                        </div>
                    </form>
                    <hr class="my-4" />
                    <!-- Data sharing options-->
                    <h5 class="mb-1">Data Sharing</h5>
                    <p class="small text-muted">Sharing usage data can help us to improve our products and better serve our users as they navigation through our application. When you agree to share usage data with us, crash reports and usage analytics will be automatically sent to our development team for investigation.</p>
                    <form>
                        <div class="form-check">
                            <input class="form-check-input" id="radioUsage1" type="radio" name="radioUsage" checked />
                            <label class="form-check-label" for="radioUsage1">Yes, share data and crash reports with app developers</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="radioUsage2" type="radio" name="radioUsage" />
                            <label class="form-check-label" for="radioUsage2">No, limit my data sharing with app developers</label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <!-- Two factor authentication card-->
            <div class="card mb-4">
                <div class="card-header">Two-Factor Authentication</div>
                <div class="card-body">
                    <p>Add another level of security to your account by enabling two-factor authentication. We will send you a text message to verify your login attempts on unrecognized devices and browsers.</p>
                    <form>
                        <div class="form-check">
                            <input class="form-check-input" id="twoFactorOn" type="radio" name="twoFactor" checked />
                            <label class="form-check-label" for="twoFactorOn">On</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="twoFactorOff" type="radio" name="twoFactor" />
                            <label class="form-check-label" for="twoFactorOff">Off</label>
                        </div>
                        <div class="mt-3">
                            <label class="small mb-1" for="twoFactorSMS">SMS Number</label>
                            <input class="form-control" id="twoFactorSMS" type="tel" placeholder="Enter a phone number" value="555-123-4567" />
                        </div>
                    </form>
                </div>
            </div>
            <!-- Delete account card-->
            <div class="card mb-4">
                <div class="card-header">Delete Account</div>
                <div class="card-body">
                    <p>Deleting your account is a permanent action and cannot be undone. If you are sure you want to delete your account, select the button below.</p>
                    <button class="btn btn-danger-soft text-danger" type="button">I understand, delete my account</button>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="container-xl px-4 mt-4">
        <!-- Account page navigation-->
        <nav class="nav nav-borders">
            <a class="nav-link ms-0" href="{{ route('template.pages.accounts.profile') }}">Profile</a>
            <a class="nav-link active" href="{{ route('template.pages.accounts.billing') }}">Billing</a>
            <a class="nav-link" href="{{ route('template.pages.accounts.security') }}">Security</a>
            <a class="nav-link" href="{{ route('template.pages.accounts.notifications') }}">Notifications</a>
        </nav>
        <hr class="mt-0 mb-4" />
        <div class="row">
            <div class="col-lg-4 mb-4">
                <!-- Billing card 1-->
                <div class="card h-100 border-start-lg border-start-primary">
                    <div class="card-body">
                        <div class="small text-muted">Current monthly bill</div>
                        <div class="h3">$20.00</div>
                        <a class="text-arrow-icon small" href="#!">
                            Switch to yearly billing
                            <i data-feather="arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <!-- Billing card 2-->
                <div class="card h-100 border-start-lg border-start-secondary">
                    <div class="card-body">
                        <div class="small text-muted">Next payment due</div>
                        <div class="h3">July 15</div>
                        <a class="text-arrow-icon small text-secondary" href="#!">
                            View payment history
                            <i data-feather="arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <!-- Billing card 3-->
                <div class="card h-100 border-start-lg border-start-success">
                    <div class="card-body">
                        <div class="small text-muted">Current plan</div>
                        <div class="h3 d-flex align-items-center">Freelancer</div>
                        <a class="text-arrow-icon small text-success" href="#!">
                            Upgrade plan
                            <i data-feather="arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Payment methods card-->
        <div class="card card-header-actions mb-4">
            <div class="card-header">
                Payment Methods
                <button class="btn btn-sm btn-primary" type="button">Add Payment Method</button>
            </div>
            <div class="card-body px-0">
                <!-- Payment method 1-->
                <div class="d-flex align-items-center justify-content-between px-4">
                    <div class="d-flex align-items-center">
                        <i class="fab fa-cc-visa fa-2x cc-color-visa"></i>
                        <div class="ms-4">
                            <div class="small">Visa ending in 1234</div>
                            <div class="text-xs text-muted">Expires 04/2024</div>
                        </div>
                    </div>
                    <div class="ms-4 small">
                        <div class="badge bg-light text-dark me-3">Default</div>
                        <a href="#!">Edit</a>
                    </div>
                </div>
                <hr />
                <!-- Payment method 2-->
                <div class="d-flex align-items-center justify-content-between px-4">
                    <div class="d-flex align-items-center">
                        <i class="fab fa-cc-mastercard fa-2x cc-color-mastercard"></i>
                        <div class="ms-4">
                            <div class="small">Mastercard ending in 5678</div>
                            <div class="text-xs text-muted">Expires 05/2022</div>
                        </div>
                    </div>
                    <div class="ms-4 small">
                        <a class="text-muted me-3" href="#!">Make Default</a>
                        <a href="#!">Edit</a>
                    </div>
                </div>
                <hr />
                <!-- Payment method 3-->
                <div class="d-flex align-items-center justify-content-between px-4">
                    <div class="d-flex align-items-center">
                        <i class="fab fa-cc-amex fa-2x cc-color-amex"></i>
                        <div class="ms-4">
                            <div class="small">American Express ending in 9012</div>
                            <div class="text-xs text-muted">Expires 01/2026</div>
                        </div>
                    </div>
                    <div class="ms-4 small">
                        <a class="text-muted me-3" href="#!">Make Default</a>
                        <a href="#!">Edit</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Billing history card-->
        <div class="card mb-4">
            <div class="card-header">Billing History</div>
            <div class="card-body p-0">
                <!-- Billing history table-->
                <div class="table-responsive table-billing-history">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th class="border-gray-200" scope="col">Transaction ID</th>
                                <th class="border-gray-200" scope="col">Date</th>
                                <th class="border-gray-200" scope="col">Amount</th>
                                <th class="border-gray-200" scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#39201</td>
                                <td>06/15/2021</td>
                                <td>$29.99</td>
                                <td><span class="badge bg-light text-dark">Pending</span></td>
                            </tr>
                            <tr>
                                <td>#38594</td>
                                <td>05/15/2021</td>
                                <td>$29.99</td>
                                <td><span class="badge bg-success">Paid</span></td>
                            </tr>
                            <tr>
                                <td>#38223</td>
                                <td>04/15/2021</td>
                                <td>$29.99</td>
                                <td><span class="badge bg-success">Paid</span></td>
                            </tr>
                            <tr>
                                <td>#38125</td>
                                <td>03/15/2021</td>
                                <td>$29.99</td>
                                <td><span class="badge bg-success">Paid</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
