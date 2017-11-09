<?php

namespace App\Repositories;

use App\Entity\BitcoinExchangeRate;
use GuzzleHttp\Client;

class CoindeskRepository implements BitcoinRepositoryInterface
{
    private $guzzle;

    public function __construct(Client $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    public function getExchangeRates()
    {
        $resource = \GuzzleHttp\json_decode($this->guzzle->request(
            'GET',
            'https://api.coindesk.com/v1/bpi/currentprice.json',
            [
                'headers' =>
                    [
                        'Accept' => 'application/json',
                        'Content-type' => 'application/json'
                    ]
            ]
        )->getBody()->getContents(), true);

        return array_values(array_map(function ($rawBitcoinExhangeRate) {
            return new BitcoinExchangeRate(array_get($rawBitcoinExhangeRate, 'code'), array_get($rawBitcoinExhangeRate, 'rate_float'));
        }, $resource['bpi']));
    }
}