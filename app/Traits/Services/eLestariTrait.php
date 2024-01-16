<?php

namespace App\Traits\Services;

use Illuminate\Support\Facades\Http;

trait eLestariTrait
{
    private $url = 'https://elestari.pendidikankelestarianjohor.edu.my/api/';

    public function getAuditTenagaData($year, $start_month, $finish_month)
    {
        $response = Http::retry(3, 100)->acceptJson()->get($this->url . 'auditTenaga/bulanan',[
            'tahun' => $year,
            'bulan_mula' => $start_month,
            'bulan_akhir' => $finish_month,
            'pbt_kod' => '0102'
        ]);

        return $response->json('data', []);
    }
}
