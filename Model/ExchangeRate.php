<?php

namespace Plewandowski\CurrencyExchangeCalculator\Model;

use Plewandowski\CurrencyExchangeCalculator\Api\Data\ExchangeRateInterface;

class ExchangeRate implements ExchangeRateInterface
{
    /**
     * @var string
     */
    private $currency;

    /**
     * @var float
     */
    private $rate;

    /**
     * @param string $currency
     * @param float $rate
     */
    public function __construct($currency, $rate)
    {
        $this->currency = strtoupper((string)$currency);
        $this->rate = (float)$rate;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }
}