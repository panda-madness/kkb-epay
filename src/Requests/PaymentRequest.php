<?php

namespace KkbEpay\Requests;


class PaymentRequest extends AbstractRequest
{
    public function buildXML()
    {
        $document = new \SimpleXMLElement('<document />');

        $merchant = $document->addChild('merchant', null);
        $merchant->addAttribute('cert_id', $this->params['MERCHANT_CERTIFICATE_ID']);
        $merchant->addAttribute('name', $this->params['MERCHANT_NAME']);

        $order = $merchant->addChild('order');
        $order->addAttribute('order_id', sprintf('%06d', $this->params['order_id']));
        $order->addAttribute('amount', $this->params['amount']);
        $order->addAttribute('currency', $this->params['currency']);

        $department = $order->addChild('department');
        $department->addAttribute('merchant_id', $this->params['MERCHANT_ID']);
        $department->addAttribute('amount', $this->params['amount']);

        if(isset($this->params['fields'])) {
            foreach ($this->params['fields'] as $field => $value) {
                $department->addAttribute($field, $value);
            }
        }

        return $document;
    }

    public function getXML()
    {
        $this->signXML();
        $xml = preg_replace('/^.+\n/', '', $this->xml->saveXML());

        return base64_encode($xml);
    }
}