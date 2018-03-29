<?php

namespace Epay\Responses;


class StatusResponse extends AbstractResponse
{
    protected $merchantPath = '/document/bank/merchant';
    protected $merchantSignPath = '/document/bank/merchant_sign';

    protected function fillProps(\SimpleXMLElement $sxi)
    {
        $props = [];

        $order = $this->xml->xpath('/document/bank/merchant/order')[0];

        $response = $this->xml->xpath('/document/bank/response')[0];

        foreach ($order->attributes() as $name => $value) {
            $props['order_' . $name] = $value;
        }

        foreach ($response->attributes() as $name => $value) {
            $props['response_' . $name] = $value;
        }

        return $props;
    }
}