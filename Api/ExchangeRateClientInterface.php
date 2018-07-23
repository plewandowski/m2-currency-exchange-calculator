<?php

namespace Plewandowski\CurrencyExchangeCalculator\Api;

/**
 * Interface ExchangeRateClientInterface
 * @api
 */
interface ExchangeRateClientInterface
{
    /**
     * @param $currencyCode
     * @return float
     */
    public function getRate($currencyCode);
}