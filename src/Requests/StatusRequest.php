<?php

namespace Epay\Requests;


class StatusRequest extends AbstractRequest
{
    public function buildXML()
    {
        $document = new \SimpleXMLElement('<document />');

        $merchant = $document->addChild('merchant', null);
        $merchant->addAttribute('id', $this->params['merchant_id']);

        $order = $merchant->addChild('order');
        $order->addAttribute('id', sprintf('%06d', $this->params['order_id']));

        return $document;
    }
}