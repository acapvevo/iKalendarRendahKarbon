@push('styles')
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" /> --}}
@endpush

<div>
    <div class="py-3 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateFinanceModal">
            {{ __('Update') }}
        </button>
    </div>

    <div class="table-responsive-lg">
        <table class="table table-bordered">
            <tr>
                <th class="w-25">{{ __('Account Name') }}</th>
                <td>{{ $finance->account_name }}</td>
            </tr>
            <tr>
                <th class="w-25">{{ __('Account Number') }}</th>
                <td>{{ $finance->account_number }}</td>
            </tr>
            <tr>
                <th class="w-25">{{ __('Bank Name') }}</th>
                <td>{{ $finance->bank ? strtoupper($finance->getBank()->name) : '' }}</td>
            </tr>
            <tr>
                <th class="w-25">{{ __('Bank Statment') }}</th>
                <td>
                    @if ($finance->bank_statement)
                        <form action="{{ route('admin.contest.winner.statement') }}" method="post" target="_blank">
                            @csrf

                            <button type="submit" class="btn btn-link" value="{{ $finance->id }}"
                                name="finance_id">{{ $finance->bank_statement }}</button>
                        </form>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- Update Finance Modal -->
    <div class="modal fade" id="updateFinanceModal" tabindex="-1" aria-labelledby="updateFinanceModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateFinanceModalLabel">{{ __('Update Finance Information') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form>
                        <div class="mb-3">
                            <label for="finance_account_name" class="form-label">{{ __('Account Name') }}</label>
                            <input type="text"
                                class="form-control {{ $errors->has('finance.account_name') ? 'is-invalid' : '' }}"
                                id="finance_account_name" placeholder="{{ __('Enter your Account Name') }}"
                                wire:model.lazy='finance.account_name' required
                                oninput="this.value = this.value.toUpperCase()">
                            @error('finance.account_name')
                                <div class="invalid-message">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3 row">
                            <div class="col-lg-8">
                                <label for="finance_account_number"
                                    class="form-label">{{ __('Account Number') }}</label>
                                <input type="text"
                                    class="form-control {{ $errors->has('finance.account_number') ? 'is-invalid' : '' }}"
                                    id="finance_account_number" placeholder="{{ __('Enter your Account Number') }}"
                                    wire:model.lazy='finance.account_number' required>
                                @error('finance.account_number')
                                    <div class="invalid-message">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-4">
                                <label for="finance_bank" class="form-label">{{ __('Bank Name') }}</label>
                                <select class="form-select {{ $errors->has('finance.bank') ? 'is-invalid' : '' }}"
                                    id="finance_bank" wire:model='finance.bank'
                                    data-placeholder="{{ __('Choose your Bank Name') }}" required>
                                    <option hidden value="">{{ __('Choose your Bank Name') }}</option>
                                    @foreach ($bank_list as $bank)
                                        <option value="{{ $bank->code }}" wire:key="bank-{{ $bank->id }}">
                                            {{ strtoupper($bank->name) }}</option>
                                    @endforeach
                                </select>
                                <div wire:ignore>
                                </div>
                                @error('finance.bank')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bank_statement_label" class="form-label">{{ __('Bank Statment') }}</label>
                            <div class="input-group custom-file-button" id="bank_statement_label">
                                <label class="input-group-text" for="file"
                                    role="button">{{ __('Browse') }}</label>
                                <label for="bank_statement"
                                    class="form-control {{ $errors->has('bank_statement') ? 'is-invalid' : '' }}"
                                    id="eviden-label" role="button">{{ $bank_statement_label }}</label>
                                <input type="file" required class="d-none form-control" id="bank_statement"
                                    wire:model.lazy="bank_statement" aria-describedby="bank_statementHelpText">
                                @error('bank_statement')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div id="bank_statementHelpText" class="form-text">
                                {{ __('Accepted Format: .jpg, .pdf, .png | Max File Size: 4MB | Make sure your Bank Statement have your Account Name and Account Number') }}
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button class="btn btn-primary" type="button" wire:loading.attr="disabled"
                        wire:click.prevent="update">
                        <span wire:loading.remove>{{ __('Save') }}</span>
                        <div wire:loading>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{ __('Saving...') }}
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/i18n/{{ LaravelLocalization::getCurrentLocale() }}.min.js">
    </script>
    <script src="{{ asset('js/select2/helper.js') }}"></script> --}}

    <script>
        // $(document).ready(function() {
        //     initSelect2('{{ LaravelLocalization::getCurrentLocale() }}', '#finance_bank', '#updateFinanceModal', function() {
        //         @this.set('finance.bank', $('#finance_bank').select2().val());
        //     });
        // });
    </script>
@endpush
