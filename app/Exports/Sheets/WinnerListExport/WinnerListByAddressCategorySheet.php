<?php

namespace App\Exports\Sheets\WinnerListExport;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class WinnerListByAddressCategorySheet implements FromView, WithTitle, ShouldAutoSize
{
    protected $category;
    protected $submissions;

    public function __construct($category, $submissions)
    {
        $this->category = $category;
        $this->submissions = $submissions;
    }

    public function view(): View
    {
        return view('exports.sheets.winner_list_by_address_category_sheet', [
            'submissions' => $this->submissions
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __($this->category->name) . '(' . $this->category->code . ')';
    }
}
