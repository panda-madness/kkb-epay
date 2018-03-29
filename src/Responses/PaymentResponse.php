<?php

namespace Epay\Responses;


class PaymentResponse extends AbstractResponse
{
    protected $merchantPath = '/document/bank/customer/merchant';
    protected $merchantSignPath = '/document/bank/customer/merchant_sign';

    protected function fillProps(\SimpleXMLElement $sxi)
    {
        $props = [];
        
        $result = $this->xml->xpath('/document/bank/results')[0];

        $payment = $result->payment;

        foreach ($result->attributes() as $name => $value) {
            $props['result'][$name] = $value;
        }

        foreach ($payment->attributes() as $name => $value) {
            $props['payment'][$name] = $value;
        }

        return $props;
    }
}