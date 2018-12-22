<?php

namespace Spatie\Geocoder;

use GuzzleHttp\Client;
use Spatie\Geocoder\Exceptions\CouldNotGeocode;

class Geocoder
{
    const RESULT_NOT_FOUND = 'result_not_found';

    /** @var \GuzzleHttp\Client */
    protected $client;

    /** @var string */
    protected $endpoint = 'https://maps.googleapis.com/maps/api/geocode/json';

    /** @var string */
    protected $apiKey;

    /** @var string */
    protected $language;

    /** @var string */
    protected $region;

    /** @var string */
    protected $bounds;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function setLanguage(string $language)
    {
        $this->language = $language;

        return $this;
    }

    public function setRegion(string $region)
    {
        $this->region = $region;

        return $this;
    }

    public function setBounds(string $bounds)
    {
        $this->bounds = $bounds;

        return $this;
    }

    public function getCoordinatesForAddress(string $address): array
    {
        if (empty($address)) {
            return $this->emptyResponse();
        }

        $payload = $this->getRequestPayload(compact('address'));

        $response = $this->client->request('GET', $this->endpoint, $payload);

        if ($response->getStatusCode() !== 200) {
            throw CouldNotGeocode::couldNotConnect();
        }

        $geocodingResponse = json_decode($response->getBody());

        if (! empty($geocodingResponse->error_message)) {
            throw CouldNotGeocode::serviceReturnedError($geocodingResponse->error_message);
        }

        if (! count($geocodingResponse->results)) {
            return $this->emptyResponse();
        }

        return $this->formatResponse($geocodingResponse);
    }

    public function getAddressForCoordinates(float $lat, float $lng): array
    {
        $payload = $this->getRequestPayload([
            'latlng' => "$lat,$lng",
        ]);

        $response = $this->client->request('GET', $this->endpoint, $payload);

        if ($response->getStatusCode() !== 200) {
            throw CouldNotGeocode::couldNotConnect();
        }

        $reverseGeocodingResponse = json_decode($response->getBody());

        if (! empty($reverseGeocodingResponse->error_message)) {
            throw CouldNotGeocode::serviceReturnedError($reverseGeocodingResponse->error_message);
        }

        if (! count($reverseGeocodingResponse->results)) {
            return $this->emptyResponse();
        }

        return $this->formatResponse($reverseGeocodingResponse);
    }

    /**
     * fetches the distance between to locations (points)
     * @param  array  $point1     - coordinates of first location
     * @param  array  $point2     - coordinates of second location
     * @param  string  $unit      - unit of location (km/mi/nmi)
     * @param  integer $decimals  - precision
     * @return string             - distance
     */
    public function getDistanceBetween($point1, $point2, $unit = 'km', $decimals = 2)
    {
        // Calculate the distance in degrees using Hervasine formula
        $degrees = $this->calcDistance($point1, $point2);

        // Convert the distance in degrees to the chosen unit (kilometres, miles or nautical miles)
        switch ($unit) {
            case 'km':
                // 1 degree = 111.13384 km, based on the average diameter of the Earth (12,735 km)
                $distance = $degrees * 111.13384;
                break;
            case 'mi':
                // 1 degree = 69.05482 miles, based on the average diameter of the Earth (7,913.1 miles)
                $distance = $degrees * 69.05482;
                break;
            case 'nmi':
                // 1 degree = 59.97662 nautic miles, based on the average diameter of the Earth (6,876.3 nautical miles)
                $distance = $degrees * 59.97662;
        }

        return round($distance, $decimals);
    }

    /**
     * calculates the distance between two points using
     * Haversine formula
     * @param  float $point1  - coordinates of first point
     * @param  float $point2  - coordinates of second point
     * @return float          - distance between both points
     */
    private function calcDistance($point1, $point2)
    {
        return rad2deg(acos((sin(deg2rad($point1['lat'])) *
                sin(deg2rad($point2['lat']))) +
            (cos(deg2rad($point1['lat'])) *
                cos(deg2rad($point2['lat'])) *
                cos(deg2rad($point1['lng'] - $point2['lng'])))));
    }

    protected function formatResponse($response): array
    {
        return [
            'lat' => $response->results[0]->geometry->location->lat,
            'lng' => $response->results[0]->geometry->location->lng,
            'accuracy' => $response->results[0]->geometry->location_type,
            'formatted_address' => $response->results[0]->formatted_address,
            'viewport' => $response->results[0]->geometry->viewport,
        ];
    }

    protected function getRequestPayload(array $parameters): array
    {
        $parameters = array_merge([
            'key' => $this->apiKey,
            'language' => $this->language,
            'region' => $this->region,
            'bounds' => $this->bounds,
        ], $parameters);

        return ['query' => $parameters];
    }

    protected function emptyResponse(): array
    {
        return [
            'lat' => 0,
            'lng' => 0,
            'accuracy' => static::RESULT_NOT_FOUND,
            'formatted_address' => static::RESULT_NOT_FOUND,
            'viewport' => static::RESULT_NOT_FOUND,
        ];
    }
}
