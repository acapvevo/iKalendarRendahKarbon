@push('styles')
@endpush

<div>
    <div class="card">
        <h1 class="card-header">{{ __('Latest Resident Registration') }}</h1>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class='table-primary'>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Address') }}</th>
                            <th>{{ __('Date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($communities as $community)
                            <tr>
                                <td>{{ $community->name ?? $community->username }}</td>
                                <td>{{ $community->address->getFullAddressInSingleLine() }}</td>
                                <td>{{ $community->created_at->format('r') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
@endpush
