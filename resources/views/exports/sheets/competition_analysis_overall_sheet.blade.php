<table>
    <thead>
        <tr>
            <th rowspan="2">{{ __('Name') }}</th>
            <th rowspan="2">{{ __('Identification Card Number') }}</th>
            <th rowspan="2">{{ __('Total Carbon Reduction') }} (kgCO<sub>2</sub>)</th>
            <th rowspan="2">{{ __('Total Carbon Emission') }} (kgCO<sub>2</sub>)</th>
            <th colspan="{{ $competition->getTwoMonthNames()->count() }}">
                {{ __('Total Carbon Reduction Each Two Month') }}</th>
            <th colspan="{{ $competition->getMonthNames()->count() }}">
                {{ __('Total Carbon Emission Each Month') }}</th>
        </tr>
        <tr>
            @foreach ($competition->getTwoMonthNames() as $months)
                <th>{{ $months }}</th>
            @endforeach
            @foreach ($competition->getMonthNames() as $month)
                <th>{{ $month }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($submissions as $submission)
            <tr>
                <td>{{ $submission->community->name }}</td>
                <td>{{ $submission->community->identification_number }}</td>
                <td>{{ $submission->calculation->total_carbon_reduction }}</td>
                <td>{{ $submission->calculation->total_carbon_emission }}</td>
                @foreach ($submission->calculation->total_carbon_reduction_each_month as $total_carbon_reduction)
                    <td>{{ $total_carbon_reduction }}</td>
                @endforeach
                @foreach ($submission->calculation->total_carbon_emission_each_month as $total_carbon_emission)
                    <td>{{ $total_carbon_emission }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
