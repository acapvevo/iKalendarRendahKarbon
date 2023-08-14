<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'number',
        'coordinates',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'coordinates' => AsCollection::class
    ];

    /**
     * Get the Addresses associated with the Submission.
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function setCoordinates($coordinates)
    {
        $this->coordinates = collect();

        foreach ($coordinates as $coordinate) {
            $latlngArray = explode(',', $coordinate);

            $this->coordinates->push([
                "lat"  => $latlngArray[0],
                "lng" => $latlngArray[1]
            ]);
        }
    }

    public function transformToInput()
    {
        return $this->coordinates->map(function ($coordinate) {
            return $coordinate['lat'] . ',' . $coordinate['lng'];
        });
    }

    public function getCoordinateLeaflet()
    {
        return $this->coordinates->map(function ($coordinate) {
            return [$coordinate['lat'], $coordinate['lng']];
        });
    }
}
