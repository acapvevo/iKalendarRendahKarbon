<?php

namespace App\Exports\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class CompetitionAnalysisOverallSheets implements FromView, WithTitle, ShouldAutoSize
{

    protected $competition;

    public function __construct($competition)
    {
        $this->competition = $competition;
    }

    public function view(): View
    {

        return view('exports.sheets.competition_analysis_overall_sheet', [
            'submissions' => $this->competition->getRanking(),
            'competition' => $this->competition,
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __("Overall");
    }
}
