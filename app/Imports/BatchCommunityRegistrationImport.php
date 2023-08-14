<?php

namespace App\Imports;

use App\Models\Community;
use App\Traits\CommunityTrait;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BatchCommunityRegistrationImport implements ToModel, WithHeadingRow
{
    use CommunityTrait;

    /**
     * @param array $row
     *
     * @return Community|null
     */
    public function model(array $row)
    {
        return $this->createCommunity([
            'username' => $row['username'],
            'email' => $row['email'],
            'password' => Hash::make($row['username']),
        ], [
            'state' => 'JOHOR',
            'country' => 'MALAYSIA'
        ], []);
    }

    /**
     * @return string|array
     */
    public function uniqueBy()
    {
        return 'email';
    }
}
