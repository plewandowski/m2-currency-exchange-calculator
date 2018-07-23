<?php

namespace Plewandowski\CurrencyExchangeCalculator\Model\ResourceModel;

use Plewandowski\CurrencyExchangeCalculator\Model\ExchangeRate;
use Plewandowski\CurrencyExchangeCalculator\Api\ExchangeRateClientInterface;
use Plewandowski\CurrencyExchangeCalculator\Api\ExchangeRateRepositoryInterface;

class ExchangeRateRepository implements ExchangeRateRepositoryInterface
{
    const CURRENCY_RUB = 'RUB';

    /**
     * @var ExchangeRateClientInterface
     */
    private $exchangeRateClient;

    /**
     * @param ExchangeRateClientInterface $exchangeRateClient
     */
    public function __construct(ExchangeRateClientInterface $exchangeRateClient)
    {
        $this->exchangeRateClient = $exchangeRateClient;
    }

    /**
     * @param string $currencyCode
     * @return Plewandowski\CurrencyExchangeCalculator\Api\Data\ExchangeRateInterface
     */
    public function getByCurrencyCode($currencyCode)
    {
        $rate = $this->exchangeRateClient->getRate($currencyCode);

        return new ExchangeRate($currencyCode, $rate);
    }
}