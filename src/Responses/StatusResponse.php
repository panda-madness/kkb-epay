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

        $props['response'] = $this->parseAttributes($response);
        $props['order'] = $this->parseAttributes($order);

        return $props;
    }

    private function parseAttributes(\SimpleXMLElement $xml): array
    {
        $props = [];

        foreach ($xml->attributes() as $name => $value) {
            $props[strtolower($name)] = (string)$value;
        }

        return $props;
    }
}