@extends('community.layouts.app')

@section('title', __('User Profile'))

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
@endsection

@section('header')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            {{ __('User Profile') }}
                        </h1>
                    </div>
                </div>
                <nav class="mt-4 rounded" aria-label="breadcrumb">
                    <ol class="breadcrumb px-3 py-2 rounded mb-0">
                        <li class="breadcrumb-item"><a href="#">{{ __('User') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Profile') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-body">
                <div class="pt-3 pb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                    @if (!$user->isVerified && !$user->identification_card)
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#verifyAccountModal">
                            {{ __('Verify Account') }}
                        </button>
                    @endif
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateUserModal">
                        {{ __('Update') }}
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th class="w-25">{{ __('Name') }}</th>
                                <td>{{ $user->name }}</td>
                                <th class="w-25">{{ __('Identification Card Number') }}</th>
                                <td>{{ $user->identification_number }}</td>
                            </tr>
                            <tr>
                                <th class="w-25">{{ __('Phone Number') }}</th>
                                <td>{{ $user->phone_number }}</td>
                                <th class="w-25">{{ __('Email Address') }}</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-center">{{ __('Occupation') }}</th>
                            </tr>
                            <tr>
                                <th class="w-25">{{ __('Place') }}</th>
                                <td colspan="3">{{ $user->occupation->position ?? __('Unemployed') }}</td>
                            </tr>
                            <tr>
                                <th class="w-25">{{ __('Position') }}</th>
                                <td>{{ $user->occupation->place ?? '' }}</td>
                                <th class="w-25">{{ __('Sector') }}</th>
                                <td>{{ strtoupper(__($user->occupation->getSector()->name ?? '')) }}</td>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-center">{{ __('Address') }}</th>
                            </tr>
                            <tr>
                                <th class="w-25">{{ __('Category') }}</th>
                                <td>{{ strtoupper(__($user->address->getCategory()->name ?? '')) }}</td>
                                <th class="w-25">{{ __('Zone') }}</th>
                                <td>{{ strtoupper($user->address->zone ? $user->address->zone->getFormalName() : '') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="w-25">{{ __('Address') }}</th>
                                <td colspan="3">
                                    {!! $user->address->getFullAddressInMultipleLine() !!}
                                </td>
                            </tr>
                            <tr>
                                <th class="w-25">{{ __('Account Status') }}</th>
                                <td colspan="3">
                                    @if (!$user->isVerified && !$user->identification_card_image)
                                        <i class="fa-solid fa-xmark" style="color: #ff0000;"></i> {{ __('Not Verified') }}
                                    @elseif (!$user->isVerified && $user->identification_card_image)
                                        <i class="fa-solid fa-arrows-spin fa-spin" style="color: #1100ff;"></i>
                                        {{ __('Verification in Process') }}
                                    @else
                                        <i class="fa-solid fa-check" style="color: #00bd0d;"></i> {{ __('Verified') }}
                                    @endif
                                    @if ($user->identification_card_image)
                                        <form action="{{ route('community.user.profile.ic') }}" method="post"
                                            target="_blank">
                                            @csrf

                                            <button class="btn btn-link" type="submit" value="{{ $user->id }}"
                                                name="community_id">{{ __('View Identification Card') }}</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="verifyAccountModal" tabindex="-1" aria-labelledby="verifyAccountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="verifyAccountModalLabel">{{ __('Verify Account') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @livewire('community.user.verification', ['user' => $user])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary"
                        form="verifyAccountForm">{{ __('Get Verification') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateUserModalLabel">{{ __('Update User Profile') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @livewire('community.user.profile', ['user' => $user])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary" form="updateUserForm">{{ __('Save') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if ($errors->any())
        <script>
            showModalOnError('updateUserModal')
        </script>
    @endif
@endpush
