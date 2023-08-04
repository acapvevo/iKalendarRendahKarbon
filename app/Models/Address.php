<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Geocoder\Laravel\Facades\Geocoder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'community_id',
        'category',
        'line_1',
        'line_2',
        'line_3',
        'city',
        'postcode',
        'state',
        'country',
    ];

    /**
     * Get the Community that owns the Address.
     */
    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function getCategory()
    {
        return DB::table('address_category')->where('code', $this->category)->first();
    }

    public function checkAddressField()
    {
        return isset($this->line_1) && isset($this->line_2) && isset($this->city) && isset($this->postcode) && isset($this->category);
    }

    public function getFullAddressInSingleLine()
    {
        $line_3 = isset($this->line_3) ? $this->line_3 . ',' : '';

        return <<<EOT
        $this->line_1,
        $this->line_2,
        $line_3
        $this->postcode $this->city,
        $this->state,
        $this->country
        EOT;
    }

    public function getFullAddressInMultipleLine()
    {
        $line_3 = isset($this->line_3) ? $this->line_3 . ',' : '';
        $address = <<<EOT
        $this->line_1,
        $this->line_2,
        $line_3
        $this->postcode $this->city,
        $this->state,
        $this->country
        EOT;

        return nl2br($address);
    }

    public function findLongitudeLatitude()
    {
        if ($this->checkAddressField()) {
            $coordinate = Geocoder::using('arcgis_online')->geocode($this->getFullAddressInSingleLine())->get()[0]->getCoordinates();

            $longitude = $coordinate->getLongitude();
            $latitude = $coordinate->getLatitude();

            return [$longitude, $latitude];
        } else
            return [0, 0];
    }
}
