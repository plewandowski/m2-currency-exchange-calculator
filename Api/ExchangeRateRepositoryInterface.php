<?php

namespace Plewandowski\CurrencyExchangeCalculator\Api;

/**
 * Interface ExchangeRateRepositoryInterface
 * @api
 */
interface ExchangeRateRepositoryInterface
{
    /**
     * @param string $currencyCode
     * @return Plewandowski\CurrencyExchangeCalculator\Api\Data\ExchangeRateInterface
     */
    public function getByCurrencyCode($currencyCode);
}