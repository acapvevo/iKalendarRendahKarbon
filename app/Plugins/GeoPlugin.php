<?php

namespace App\Plugins;

use Torann\GeoIP\Services\AbstractService;

class GeoPlugin extends AbstractService
{
    /**
     * {@inheritdoc}
     */
    public function locate($ip)
    {
        $data = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip));

        return [
            'ip' => $data['geoplugin_request'],
            'iso_code' => $data['geoplugin_countryCode'],
            'country' => $data['geoplugin_countryName'],
            'city' => $data['geoplugin_city'],
            'state' => $data['geoplugin_region'],
            'state_name' => $data['geoplugin_regionName'],
            'lat' => $data['geoplugin_latitude'],
            'lon' => $data['geoplugin_longitude'],
            'timezone' => $data['geoplugin_timezone'],
            'continent' => $data['geoplugin_continentCode'],
        ];
    }

    /**
     * Update function for service.
     *
     * @return string
     */
    public function update()
    {
        // Optional artisan command line update method
    }
}
