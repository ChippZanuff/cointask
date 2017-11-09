<?php

namespace App\Repositories;

use App\Entity\BitcoinExchangeRate;
use GuzzleHttp\Client;

class CoindeskRepository implements BitcoinRepositoryInterface
{
    private $guzzle, $path;

    public function __construct(Client $guzzle, $path = 'https://api.coindesk.com/v1/bpi/currentprice.json')
    {
        $this->guzzle = $guzzle;
        $this->path = $path;
    }

    public function getExchangeRates()
    {
        $resource = \GuzzleHttp\json_decode($this->guzzle->request(
            'GET',
            $this->path,
            [
                'headers' =>
                    [
                        'Accept' => 'application/json',
                        'Content-type' => 'application/json'
                    ]
            ]
            )->getBody()->getContents(), true);

        return array_values(array_map(function($rawBitcoinExhangeRate) {
            return new BitcoinExchangeRate(array_get($rawBitcoinExhangeRate, 'code'), array_get($rawBitcoinExhangeRate, 'rate_float'));
        }, $resource['bpi']));
    }
}