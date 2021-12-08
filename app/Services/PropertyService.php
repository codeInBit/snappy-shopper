<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use URL;

class PropertyService
{
    public function addPropertiesFromDictionary()
    {
        $url = URL::to('/api/properties');
        $path = public_path() . "/json/properties.json";
        $json = json_decode(file_get_contents($path), true);

        foreach ($json['Properties'] as $property) {
            Http::post(
                $url,
                [
                    'name' => $property['name'],
                    'price' => $property['price'],
                    'type' => $property['type'],
                ]
            );
        }

        return;
    }
}
