<?php

namespace Plewandowski\CurrencyExchangeCalculator\Api\Data;

/**
 * Interface ExchangeRateInterface
 * @api
 */
interface ExchangeRateInterface
{
    /**
     * @return string
     */
    public function getCurrency();

    /**
     * @return float
     */
    public function getRate();
}