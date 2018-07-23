<?php

namespace Plewandowski\CurrencyExchangeCalculator\Api;

use Plewandowski\Exception\RateClientException;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface ExchangeRateRepositoryInterface
 * @api
 */
interface ResponseValidatorInterface
{
    /**
     * @param ResponseInterface $response
     * @throws RateClientException
     */
    public function validate(ResponseInterface $response);
}