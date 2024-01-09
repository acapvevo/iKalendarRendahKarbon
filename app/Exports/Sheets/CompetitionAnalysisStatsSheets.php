<?php

namespace App\Exports\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CompetitionAnalysisStatsSheets implements FromView, WithTitle, ShouldAutoSize
{
    protected $competition;

    public function __construct($competition)
    {
        $this->competition = $competition;
    }

    public function view(): View
    {
        return view('exports.sheets.competition_analysis_stats_sheet', [
            'competition' => $this->competition,
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __("Stats");
    }
}
