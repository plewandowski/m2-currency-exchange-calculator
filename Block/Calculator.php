<?php

namespace Plewandowski\CurrencyExchangeCalculator\Block;

class Calculator extends \Magento\Framework\View\Element\Template
{
    /**
     * @return string
     */
    public function getComponentDataJson()
    {
        return json_encode($this->getComponentData());
    }

    /**
     * @return array
     */
    private function getComponentData()
    {
        return [
            'validation' => [
                'rules' => $this->getInputValidationRules()
            ],
            'currencyExchangeCalculator' => [
                'currencyCode' => $this->getCurrency(),
            ]
        ];
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return 'RUB';
    }

    /**
     * @return array
     */
    private function getInputValidationRules()
    {
        return [
            'amount' => [
                'required' => true,
                'number' => true,
                'min' => 0.01,
            ]
        ];
    }
}