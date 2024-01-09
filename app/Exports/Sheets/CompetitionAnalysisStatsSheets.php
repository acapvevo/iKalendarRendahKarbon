<?php

namespace App\Exports\Sheets;

use App\Traits\SubmissionTrait;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CompetitionAnalysisStatsSheets implements FromView, WithTitle, ShouldAutoSize
{
    use SubmissionTrait;

    protected $competition;

    public function __construct($competition)
    {
        $this->competition = $competition;
    }

    public function view(): View
    {
        $submission_categories = $this->getSubmissionCategories();

        return view('exports.sheets.competition_analysis_stats_sheet', [
            'competition' => $this->competition,
            'calculation' => $this->competition->calculation,
            'stat' => $this->competition->stat,
            'submission_categories' => $submission_categories
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __("Statistic");
    }
}
