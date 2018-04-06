<?php

namespace KkbEpay\Responses;


class PaymentResponse extends AbstractResponse
{
    protected $merchantPath = '/document/bank/customer/merchant';
    protected $merchantSignPath = '/document/bank/customer/merchant_sign';

    protected function parse(\SimpleXMLElement $sxi) : array
    {
        $props = [];

        $order = $this->xml->xpath('/document/bank/customer/merchant/order')[0];
        
        $result = $this->xml->xpath('/document/bank/results')[0];

        $payment = $result->payment;

        $props['result'] = $this->parseAttributes($result);
        $props['payment'] = $this->parseAttributes($payment);
        $props['order'] = $this->parseAttributes($order);

        return $props;
    }

    private function parseAttributes(\SimpleXMLElement $xml) {
        $props = [];

        foreach ($xml->attributes() as $name => $value) {
            $props[strtolower($name)] = $value;
        }

        return $props;
    }
}