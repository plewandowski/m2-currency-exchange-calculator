<?php

namespace Plewandowski\CurrencyExchangeCalculator\Model\Client\Nbp;

use GuzzleHttp\Exception\GuzzleException;
use Plewandowski\CurrencyExchangeCalculator\Api\ExchangeRateClientInterface;
use Plewandowski\CurrencyExchangeCalculator\Api\ResponseValidatorInterface;
use Plewandowski\CurrencyExchangeCalculator\Exception\RateClientException;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class NbpClient
 */
class NbpClient implements ExchangeRateClientInterface
{
    const ENDPOINT_SINGLE_CURRENCY = 'http://api.nbp.pl/api/exchangerates/rates/{table}/{code}/';

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var ResponseValidatorInterface
     */
    private $responseValidator;

    /**
     * @param ClientInterface $httpClient
     * @param ResponseValidatorInterface $responseValidator
     */
    public function __construct(ClientInterface $httpClient, ResponseValidatorInterface $responseValidator)
    {
        $this->httpClient = $httpClient;
        $this->responseValidator = $responseValidator;
    }

    /**
     * @param string $currencyCode
     *
     * @throws RateClientException
     * @return float
     */
    public function getRate($currencyCode)
    {
        $options = [
            'headers' => [
                'Accept' => 'application/xml'
            ]
        ];

        try {
            $response = $this->httpClient->request('GET', $this->getUri($currencyCode), $options);
            $this->responseValidator->validate($response);
            $rate = $this->fetchRate($response);
        } catch(GuzzleException $e) {
            throw new RateClientException(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }

        return $rate;
    }

    /**
     * @param string $currencyCode
     * @return string
     */
    private function getUri($currencyCode)
    {
        $currencyCode = trim(strtoupper($currencyCode));
        $table = 'A';

        $url = self::ENDPOINT_SINGLE_CURRENCY;
        $url = str_replace('{table}', $table, $url);
        $url = str_replace('{code}', $currencyCode, $url);

        return $url;
    }

    /**
     * @param ResponseInterface $response
     * @return float
     */
    private function fetchRate(ResponseInterface $response)
    {
        $sxe = new \SimpleXMLElement((string)$response->getBody());

        return floatval((string)$sxe->Rates->Rate->Mid);
    }
}