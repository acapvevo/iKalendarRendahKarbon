<?php

namespace App\Exports\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CompetitionAnalysisByAddressCategorySheet implements FromView, WithTitle, ShouldAutoSize
{
    protected $competition;
    protected $category;
    protected $submissions;

    public function __construct($competition, $category, $submissions)
    {
        $this->competition = $competition;
        $this->category = $category;
        $this->submissions = $submissions;
    }

    public function view(): View
    {
        return view('exports.sheets.competition_analysis_by_address_category_sheet', [
            'submissions' => $this->submissions,
            'competition' => $this->competition,
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __("Category") . ' ' . $this->category->code . ': ' . __($this->category->name);
    }
}
