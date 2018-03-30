<?php

namespace KkbEpay\Responses;


class StatusResponse extends AbstractResponse
{
    protected $merchantPath = '/document/bank/merchant';
    protected $merchantSignPath = '/document/bank/merchant_sign';

    /**
     * @inheritdoc
     */
    protected function parse(\SimpleXMLElement $xml)
    {
        $props = [];

        $order = $this->xml->xpath('/document/bank/merchant/order')[0];

        $response = $this->xml->xpath('/document/bank/response')[0];

        foreach ($order->attributes() as $name => $value) {
            $props['order'][$name] = (string)$value;
        }

        foreach ($response->attributes() as $name => $value) {
            $props['response'][$name] = (string)$value;
        }

        return $props;
    }
}