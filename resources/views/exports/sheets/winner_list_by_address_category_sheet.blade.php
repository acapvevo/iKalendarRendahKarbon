<table>
    <thead>
        <tr>
            <th>{{ __('Rank') }}</th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Username') }}</th>
            <th>{{ __('Identification Card Number') }}</th>
            <th>{{ __('Identification Card') }} {{ __('Verified') }}?</th>
            <th>{{ __('Email') }}</th>
            <th>{{ __('Phone Number') }}</th>
            <th>{{ __('Address') }}</th>
            <th>{{ __('Total Carbon Reduction') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($submissions as $s => $submissionObj)
            <tr>
                <td>{{ $s + 1 }}</td>
                <td>{{ $submissionObj->community->name }}</td>
                <td>{{ $submissionObj->community->username }}</td>
                <td>{{ $submissionObj->community->identification_number }}</td>
                <td>{{ $submissionObj->community->isVerified ? __('Verified') : __('Not Verified') }}</td>
                <td>{{ $submissionObj->community->email }}</td>
                <td>{{ $submissionObj->community->getPhoneNumber() }}</td>
                <td>{{ $submissionObj->community->address->getFullAddressInSingleLine() }}</td>
                <td>{{ abs($submissionObj->calculation->total_carbon_reduction) }} kgCO<sub>2</sub></td>
            </tr>
        @endforeach
    </tbody>
</table>
