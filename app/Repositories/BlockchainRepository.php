<?php

namespace App\Repositories;

use App\Entity\BitcoinExchangeRate;
use GuzzleHttp\Client;

class BlockchainRepository implements BitcoinRepositoryInterface
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
            'https://blockchain.info/ru/ticker',
            [
                'headers' =>
                    [
                        'Accept' => 'application/json',
                        'Content-type' => 'application/json'
                    ]
            ]
            )->getBody()->getContents(), true);

        $currencies = [];
        foreach ($resource as $currency => $rawBitcoinExhangeRate)
        {
            $currencies[] = new BitcoinExchangeRate($currency, array_get($rawBitcoinExhangeRate, 'buy'));
        }

        return $currencies;
    }
}