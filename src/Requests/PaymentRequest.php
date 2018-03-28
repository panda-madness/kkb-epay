<?php

namespace Epay\Requests;


class PaymentRequest extends AbstractRequest implements RequestInterface
{
    public function xml()
    {
        $document = new \SimpleXMLElement('<document />');

        $merchant = $document->addChild('merchant', null);
        $merchant->addAttribute('cert_id', $this->params['certificate_id']);
        $merchant->addAttribute('name', $this->params['merchant_name']);

        $order = $merchant->addChild('order');
        $order->addAttribute('order_id', sprintf('%06d', $this->params['order_id']));
        $order->addAttribute('amount', $this->params['amount']);
        $order->addAttribute('currency', $this->params['currency']);

        $department = $order->addChild('department');
        $department->addAttribute('merchant_id', $this->params['merchant_id']);
        $department->addAttribute('amount', $this->params['amount']);

        if(isset($this->params['fields'])) {
            foreach ($this->params['fields'] as $field => $value) {
                $department->addAttribute($field, $value);
            }
        }

        return base64_encode($this->formatAndSignXml($document));
    }
}