<?php

namespace Plewandowski\CurrencyExchangeCalculator\Model\Client\Nbp;

use Plewandowski\CurrencyExchangeCalculator\Api\ResponseValidatorInterface;
use Plewandowski\CurrencyExchangeCalculator\Exception\RateClientException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class NbpResponseValidator
 */
class NbpResponseValidator implements ResponseValidatorInterface
{
    /**
     * @param ResponseInterface $response
     * @throws RateClientException
     */
    public function validate(ResponseInterface $response)
    {
        $this->isResponseSuccessful($response);
        $this->isResponseBodyValid($response);
    }

    /**
     * @param ResponseInterface $response
     * @throws RateClientException
     */
    private function isResponseSuccessful(ResponseInterface $response)
    {
        if ($response->getStatusCode() !== 200) {
            throw new RateClientException(sprintf(
                'Request was not successful. Status code %s',
                $response->getStatusCode()
            ));
        }
    }

    /**
     * @param ResponseInterface $response
     * @throws RateClientException
     */
    private function isResponseBodyValid(ResponseInterface $response)
    {
        $domDocument = new \DOMDocument();
        $domDocument->loadXML((string)$response->getBody());

        $schemaFile = realpath(__DIR__ . '/schema/response.xsd');

        if (!$domDocument->schemaValidate($schemaFile)) {
            throw new RateClientException('Response does not validate against schema file');
        }
    }
}