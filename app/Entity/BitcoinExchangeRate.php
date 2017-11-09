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
        return [$this->currency => $this->exchangeRate];
    }
}