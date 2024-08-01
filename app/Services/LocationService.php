<?php

namespace App\Services;

class LocationService
{
    public static function isWithinOfficeRadius($latitude, $longitude)
    {
        $officeLatitude = env('OFFICE_LATITUDE');
        $officeLongitude = env('OFFICE_LONGITUDE');
        $radius = 100; // in meters

        $earthRadius = 6371000; // Earth radius in meters

        $latFrom = deg2rad($officeLatitude);
        $lonFrom = deg2rad($officeLongitude);
        $latTo = deg2rad($latitude);
        $lonTo = deg2rad($longitude);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        $distance = $angle * $earthRadius;

        return $distance <= $radius;
    }
}
