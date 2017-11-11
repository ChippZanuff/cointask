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
            if($this->isUsd($currency))
            {
                $currencies[] = new BitcoinExchangeRate($currency, $rawBitcoinExhangeRate['buy']);
            }
            if($this->isGbp($currency))
            {
                $currencies[] = new BitcoinExchangeRate($currency, $rawBitcoinExhangeRate['buy']);
            }
            if($this->isEur($currency))
            {
                $currencies[] = new BitcoinExchangeRate($currency, $rawBitcoinExhangeRate['buy']);
            }
        }

        return $currencies;
    }

    public function isGbp($currency)
    {
        return $currency == 'GBP';
    }

    public function isUsd($currency)
    {
        return $currency == 'USD';
    }

    public function isEur($currency)
    {
        return $currency == 'EUR';
    }
}