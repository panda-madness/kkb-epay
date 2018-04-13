<?php

namespace KkbEpay\Requests;


class StatusRequest extends AbstractRequest
{
    public function buildXML()
    {
        $document = new \SimpleXMLElement('<document />');

        $merchant = $document->addChild('merchant', null);
        $merchant->addAttribute('id', $this->clientOptions['MERCHANT_ID']);

        $order = $merchant->addChild('order');
        $order->addAttribute('id', sprintf('%06d', $this->requestParams['order_id']));

        return $document;
    }

    public function getContents()
    {
        return (string)$this->getXML();
    }
}