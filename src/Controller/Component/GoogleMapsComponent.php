<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * GoogleMaps component
 */
class GoogleMapsComponent extends Component
{

    const GEOCODE_URL = 'https://maps.googleapis.com/maps/api/geocode/xml';
    const GOOGLE_MAPS_API_KEY = 'AIzaSyCfmoy0os_K4_e7tNwjvktuAbTU4SAYsao';

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function getGeoInfo($data)
    {
        $path = sprintf('%s?address=%s&key=%s', self::GEOCODE_URL, urlencode($data), self::GOOGLE_MAPS_API_KEY);

        $context = stream_context_create(array('ssl' => array(
            'verify_peer' => true,
            'cafile' => WWW_ROOT . '/ca-bundle.crt'
        )));
        libxml_set_streams_context($context);

        $xml = simplexml_load_file($path);

        if (!empty($xml)) {
            if ($xml->status == 'OK') {
                return [
                    'latitude' => $xml->result->geometry->location->lat,
                    'longitude' => $xml->result->geometry->location->lng,
                ];
            }
        }

        return [
            'latitude' => null,
            'longitude' => null,
        ];
    }
}
