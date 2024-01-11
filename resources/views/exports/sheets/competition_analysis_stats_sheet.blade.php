<table>
    <tr>
        <th colspan="3">{{ __('Carbon Emission Statistic') }}</th>
    </tr>
    <tr>
        <th colspan="2">{{ __('Total Carbon Emission') }}</th>
        <td>{{ number_format($calculation->total_carbon_emission, 2) }} kgCO<sub>2</sub></td>
    </tr>
    <tr>
        <th colspan="2">{{ __('Average Carbon Emission by Month') }}</th>
        <td>{{ number_format($calculation->average_carbon_emission_by_month, 2) }} kgCO<sub>2</sub></td>
    </tr>
    @foreach ($submission_categories as $c => $category)
        <tr>
            @if ($c == 0)
                <th rowspan="{{ $submission_categories->count() }}">{{ __('Total Carbon Emission By Category') }}</th>
            @endif
            <td>{{ __($category->description) }}</td>
            <td>{{ number_format($calculation->total_carbon_emission_each_type[$category->name], 2) }}
                kgCO<sub>2</sub></td>
        </tr>
    @endforeach
    @foreach ($competition->getMonthRange() as $m => $month)
        <tr>
            @if ($m == $competition->getMonthRange()->keys()->first())
                <th rowspan="{{ $competition->getMonthRange()->count() }}">{{ __('Total Carbon Emission By Month') }}</th>
            @endif
            <td>{{ $month->getName() }}</td>
            <td>{{ number_format($calculation->total_carbon_emission_each_month[$month->id], 2) }}
                kgCO<sub>2</sub></td>
        </tr>
    @endforeach
    <tr></tr>
    <tr></tr>
    <tr>
        <th colspan="3">{{ __('Submission Statistic') }}</th>
    </tr>
    <tr>
        <th colspan="2">{{ __('Total Submission') }}</th>
        <td>{{ number_format($stat->total_submission, 2) }} {{ __('Resident') }}</td>
    </tr>
    <tr>
        <th colspan="2">{{ __('Average Submission by Month') }}</th>
        <td>{{ number_format($stat->average_submission_by_month, 2) }} {{ __('Resident') }}</td>
    </tr>
    @foreach ($submission_categories as $c => $category)
        <tr>
            @if ($c == 0)
                <th rowspan="{{ $submission_categories->count() }}">{{ __('Total Submission By Category') }}</th>
            @endif
            <td>{{ __($category->description) }}</td>
            <td>{{ number_format($stat->total_submission_each_type[$category->name], 2) }}
                {{ __('Resident(s)') }}</td>
        </tr>
    @endforeach
    @foreach ($competition->getMonthRange() as $m => $month)
        <tr>
            @if ($m == $competition->getMonthRange()->keys()->first())
                <th rowspan="{{ $competition->getMonthRange()->count() }}">{{ __('Total Submission By Month') }}</th>
            @endif
            <td>{{ $month->getName() }}</td>
            <td>{{ number_format($stat->total_submission_each_month[$month->id], 2) }}
                {{ __('Resident(s)') }}</td>
        </tr>
    @endforeach
</table>
