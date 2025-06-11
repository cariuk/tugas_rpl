<?php

namespace App\Services;

use App\Exceptions\RajaOngkirApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class RajaOngkirService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected Client $client)
    {

    }

    /**
     * @throws GuzzleException
     * @throws RajaOngkirApiException
     */
    function getDestination($params): array
    {
        try {
            $result = $this->client->request('GET', env('RAJA_ONGKIR_ENDPOINT') . "/destination/domestic-destination", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'key' => env('RAJA_ONGKIR_KEY')
                ],
                'query' => [
                    'search' => $params->search,
                ]
            ]);

            $result = json_decode($result->getBody()->getContents());

            if ($result->meta->code != 200) {
                throw new RajaOngkirApiException(
                    "Raja Ongkir API Error: " . ($json['rajaongkir']['status']['description'] ?? 'Unknown error'),
                    $json['rajaongkir']['status']['code'] ?? 0,
                    null, // Previous throwable
                    $result->meta->code, // HTTP status code from Raja Ongkir response
                    $json['rajaongkir']['status']['description'] ?? 'No description' // Raja Ongkir specific error message
                );
            }

            return $result->data;
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $body = json_decode($response->getBody()->getContents());

            throw new RajaOngkirApiException(
                "Raja Ongkir API Error: " . $body->meta?->message ?? 'Unknown error',
                $response->getStatusCode(),
                null,
                $response->getStatusCode(),
                $body->meta?->status ?? 'No description'
            );
        }
    }

    function getDomesticCost($params): array
    {
        try {
            $result = $this->client->request('POST', env('RAJA_ONGKIR_ENDPOINT') . "/calculate/domestic-cost", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'key' => env('RAJA_ONGKIR_KEY')
                ],
                'query' => [
                    "origin" => env('RAJA_ONGKIR_ORIGIN'),
                    "destination" => $params->destination['id'],
                    "weight" => $params->weight,
                    "courier" => "jne:sicepat:jnt"
                ]
            ]);

            $result = json_decode($result->getBody()->getContents());

            if ($result->meta->code != 200) {
                throw new RajaOngkirApiException(
                    "Raja Ongkir API Error: " . ($json['rajaongkir']['status']['description'] ?? 'Unknown error'),
                    $json['rajaongkir']['status']['code'] ?? 0,
                    null, // Previous throwable
                    $result->meta->code, // HTTP status code from Raja Ongkir response
                    $json['rajaongkir']['status']['description'] ?? 'No description' // Raja Ongkir specific error message
                );
            }

            return $result->data;
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $body = json_decode($response->getBody()->getContents());

            throw new RajaOngkirApiException(
                "Raja Ongkir API Error: " . $body->meta?->message ?? 'Unknown error',
                $response->getStatusCode(),
                null,
                $response->getStatusCode(),
                $body->meta?->status ?? 'No description'
            );
        }
    }
}
