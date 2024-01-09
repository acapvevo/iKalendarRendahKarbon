<?php

namespace App\Exports;

use App\Traits\AddressTrait;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\CompetitionAnalysisOverallSheets;
use App\Exports\Sheets\CompetitionAnalysisByAddressCategorySheet;
use App\Exports\Sheets\CompetitionAnalysisStatsSheets;

class CompetitionAnaysisExport implements WithMultipleSheets, WithEvents
{
    use Exportable, AddressTrait;

    protected $competition;

    public function __construct($competition)
    {
        $this->competition = $competition;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $address_categories = $this->getAddressCategories();

        $sheets[] = new CompetitionAnalysisOverallSheets($this->competition);

        foreach($address_categories as $category){
            $submissions = $this->competition->getRankingByAddressCategory($category->code);
            $sheets[] = new CompetitionAnalysisByAddressCategorySheet($this->competition, $category, $submissions);
        }

        return $sheets;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $workSheet = $event->sheet->getDelegate();
                $workSheet->freezePane('A2'); // freezing here
            },
        ];
    }
}
