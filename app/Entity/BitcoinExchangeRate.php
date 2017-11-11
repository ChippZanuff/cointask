<?php

namespace App\Entity;

class BitcoinExchangeRate
{
    private $currency;
    private $exchangeRate;

    public function __construct($currency, $exchangeRate)
    {
        $this->currency = $currency;
        $this->exchangeRate = $exchangeRate;
    }

    public function toArray()
    {
        return ['currency' => $this->currency, 'exchange_rate' => $this->exchangeRate];
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return mixed
     */
    public function getExchangeRate()
    {
        return $this->exchangeRate;
    }
}