<div>
    <form class="auth-form auth-signup-form" id="communityRegistrationForm">
        <ul class="nav nav-pills nav-justified" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="wizard1-tab" data-bs-toggle="tab" data-bs-target="#wizard1-tab-pane"
                    type="button" role="tab" aria-controls="wizard1-tab-pane" wire:ignore.self aria-selected="true"
                    wire:click.prevent="setTab(1)">
                    <div>
                        {{ __('Account') }}
                        {!! $errors->has('user.username') || $errors->has('user.email') || $errors->has('password')
                            ? '<span class="badge text-bg-danger">!</span>'
                            : '' !!}
                    </div>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="wizard2-tab" data-bs-toggle="tab" data-bs-target="#wizard2-tab-pane"
                    type="button" role="tab" aria-controls="wizard2-tab-pane" wire:ignore.self
                    aria-selected="false" wire:click.prevent="setTab(2)">
                    <div>
                        {{ __('Confirmation') }}
                    </div>
                </button>
            </li>
        </ul>
        <div class="tab-content pt-3" id="myTabContent">
            <div class="tab-pane fade show active" id="wizard1-tab-pane" role="tabpanel" aria-labelledby="wizard1-tab"
                tabindex="0" wire:ignore.self>

                <div class="mb-3">
                    <label for="user.username" class="form-label">{{ __('Username') }}:</label>
                    <input type="text" class="form-control {{ $errors->has('user.username') ? 'is-invalid' : '' }}"
                        placeholder="{{ __('Enter Your Username') }}" id="user.username" aria-label="username"
                        aria-describedby="username" wire:model.lazy="user.username" required>
                    @error('user.username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="user.email" class="form-label">{{ __('Email Address') }}:</label>
                    <input type="email" class="form-control {{ $errors->has('user.email') ? 'is-invalid' : '' }}"
                        placeholder="{{ __('Enter Your Email Address') }}" id="user.email" aria-label="email"
                        aria-describedby="email" wire:model.lazy="user.email" required>
                    @error('user.email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}:</label>
                    <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                        placeholder="{{ __('Enter Your Password') }}" id="password" aria-label="password"
                        aria-describedby="passwordHelpBlock" wire:model.lazy="password" required>
                    <div id="passwordHelpBlock" class="form-text">
                        {{__('Your password must be more than 8 characters')}}
                    </div>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">{{ __('Password Confirmation') }}:</label>
                    <input type="password"
                        class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                        placeholder="{{ __('Enter Your Password Again') }}" id="password_confirmation"
                        aria-label="password_confirmation" aria-describedby="password_confirmation"
                        wire:model.lazy="password_confirmation" required>
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>
            <div class="tab-pane fade" id="wizard2-tab-pane" role="tabpanel" aria-labelledby="wizard2-tab"
                tabindex="0" wire:ignore.self>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th colspan="4" class="text-center">{{ __('Account') }}</th>
                        </tr>
                        <tr>
                            <th class="w-25">{{ __('Username') }}</th>
                            <td colspan="3">{{ $user->username ?? '' }}</td>
                        </tr>
                        <tr>
                            <th class="w-25">{{ __('Email Address') }}</th>
                            <td colspan="3">{{ $user->email ?? '' }}</td>
                        </tr>
                        <tr>
                            <th class="w-25">{{ __('Password') }}</th>
                            <td colspan="3">
                                <div class="row row-cols-lg-auto g-2 align-items-center">

                                    <div class="col-12">
                                        <input type="password" readonly class="form-control-plaintext"
                                            id="password_preview" value="{{ $password ?? '' }}">
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-outline-secondary btn-sm float-end"
                                            id="password_preview_btn" wire:click.prevent="toogleVisibility"><i
                                                class="fa-regular fa-eye"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="mb-3 d-flex justify-content-center align-items-center">
                    <div wire:ignore>
                        {!! htmlScriptTagJsApi() !!}
                        {!! htmlFormSnippet([
                            'callback' => 'onCallback',
                        ]) !!}
                    </div>
                    @error('captcha')
                        <br>
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Form Group (create account submit)-->
        <div class="pt-3 pb-3 d-flex justify-content-center align-items-center">
            @if ($tab_state != 1)
                <button class="btn btn-danger btn-block" type="button" wire:click.prevent="previousTab">
                    {!! __('pagination.previous') !!}
                </button>
            @endif
            <div class="mx-3">
                @if ($tab_state == 2)
                    <button class="btn btn-primary btn-block" type="button" wire:loading.attr="disabled"
                        wire:click.prevent="create">
                        <span wire:loading.remove>{{ __('Create Account') }}</span>
                        <div wire:loading wire:target="create">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{ __('Creating Account...') }}
                        </div>
                    </button>
                @else
                    <button class="btn btn-success btn-block" type="button" wire:click.prevent="nextTab">
                        {!! __('pagination.next') !!}
                    </button>
                @endif
            </div>
        </div>
    </form>
</div>

@push('scripts')
    <script>
        var onCallback = function() {
            @this.set('captcha', grecaptcha.getResponse());
        }

        Livewire.on('changeTab', tab_state => {
            const wizardTab = document.getElementById('wizard' + tab_state + '-tab');
            bootstrap.Tab.getOrCreateInstance(wizardTab).show();
        })

        Livewire.on('tooglePasswordVisibility', isVisible => {
            const password_preview = document.getElementById('password_preview');
            const password_preview_btn = document.getElementById('password_preview_btn');

            if (isVisible) {
                password_preview.type = 'text';
                password_preview_btn.innerHtml = '<i class="fa-regular fa-eye-slash"></i>';

            } else {
                password_preview.type = 'password';
                password_preview_btn.innerHtml = '<i class="fa-regular fa-eye"></i>';
            }
        })
    </script>
@endpush
