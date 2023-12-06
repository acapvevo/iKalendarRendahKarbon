<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BanksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = <<< EOT
        [
            {
                "name": "Maybank",
                "code": "27"
            },
            {
                "name": "CIMB Bank",
                "code": "35"
            },
            {
                "name": "RHB Bank",
                "code": "18"
            },
            {
                "name": "Bank Islam",
                "code": "45"
            },
            {
                "name": "Bank Muamalat",
                "code": "41"
            },
            {
                "name": "Bank Rakyat",
                "code": "02"
            },
            {
                "name": "Bank Simpanan Nasional",
                "code": "10"
            },
            {
                "name": "Citibank",
                "code": "17"
            },
            {
                "name": "Hong Leong Bank",
                "code": "24"
            },
            {
                "name": "HSBC Bank",
                "code": "22"
            },
            {
                "name": "OCBC Bank",
                "code": "29"
            },
            {
                "name": "Public Bank",
                "code": "33"
            },
            {
                "name": "Affin Bank",
                "code": "32"
            },
            {
                "name": "AmBank",
                "code": "08"
            },
            {
                "name": "Agro Bank",
                "code": "49"
            },
            {
                "name": "Alliance Bank",
                "code": "12"
            },
            {
                "name": "Al-Rajhi Bank",
                "code": "53"
            },
            {
                "name": "Bank of China",
                "code": "42"
            },
            {
                "name": "Bank of America",
                "code": "07"
            },
            {
                "name": "Bank of Tokyo-Mitsubishi UFJ",
                "code": "52"
            },
            {
                "name": "BNP Paribas",
                "code": "60"
            },
            {
                "name": "Deutsche Bank",
                "code": "19"
            },
            {
                "name": "Industrial & Commercial Bank of China",
                "code": "59"
            },
            {
                "name": "JP Morgan Chase Bank",
                "code": "48"
            },
            {
                "name": "Kuwait Finance House",
                "code": "47"
            },
            {
                "name": "Mizuho Bank",
                "code": "73"
            },
            {
                "name": "Standard Chartered Bank",
                "code": "14"
            },
            {
                "name": "Sumitomo Mitsui Banking Corporation",
                "code": "51"
            },
            {
                "name": "The Royal Bank of Scotland",
                "code": "46"
            },
            {
                "name": "United Overseas Bank",
                "code": "26"
            }
        ]
        EOT;

        DB::table('banks')->insertTs(json_decode($banks, true));
    }
}
