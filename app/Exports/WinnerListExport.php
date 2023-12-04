<?php

namespace App\Exports;

use App\Exports\Sheets\WinnerListExport\WinnerListByAddressCategorySheet;
use App\Traits\AddressTrait;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class WinnerListExport implements WithMultipleSheets
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

        foreach($address_categories as $category){
            $submissions = $this->competition->getRankingByAddressCategory($category->code);
            $sheets[] = new WinnerListByAddressCategorySheet($category, $submissions);
        }

        return $sheets;
    }
}
