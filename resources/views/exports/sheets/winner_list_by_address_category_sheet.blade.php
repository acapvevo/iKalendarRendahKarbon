<table>
    <thead>
        <tr>
            <th>{{ __('Rank') }}</th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Phone Number') }}</th>
            <th>{{ __('Address') }}</th>
            <th>{{ __('Total Carbon Reduction') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($submissions as $s => $submissionObj)
            <tr>
                <td>{{ $s + 1 }}</td>
                <td>{{ $submissionObj->community->name ?? $submissionObj->community->username }}</td>
                <td>{{ $submissionObj->community->getPhoneNumber() }}</td>
                <td>{{ $submissionObj->community->address->getFullAddressInSingleLine() }}</td>
                <td>{{ abs($submissionObj->calculation->total_carbon_reduction) }} kgCO<sub>2</sub></td>
            </tr>
        @endforeach
    </tbody>
</table>
