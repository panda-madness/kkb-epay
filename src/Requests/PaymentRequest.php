<?php

namespace KkbEpay\Requests;


class PaymentRequest extends AbstractRequest
{
    public function buildXML()
    {
        $document = new \SimpleXMLElement('<document />');

        $merchant = $document->addChild('merchant', null);
        $merchant->addAttribute('cert_id', $this->clientOptions['MERCHANT_CERTIFICATE_ID']);
        $merchant->addAttribute('name', $this->clientOptions['MERCHANT_NAME']);

        $order = $merchant->addChild('order');
        $order->addAttribute('order_id', sprintf('%06d', $this->requestParams['order_id']));
        $order->addAttribute('amount', $this->requestParams['amount']);
        $order->addAttribute('currency', $this->requestParams['currency']);

        $department = $order->addChild('department');
        $department->addAttribute('merchant_id', $this->clientOptions['MERCHANT_ID']);
        $department->addAttribute('amount', $this->requestParams['amount']);

        if(isset($this->requestParams['fields'])) {
            foreach ($this->requestParams['fields'] as $field => $value) {
                $department->addAttribute($field, $value);
            }
        }

        return $document;
    }

    public function getContents()
    {
        return [
            'Signed_Order_B64' => base64_encode($this->getXML()),
            'BackLink' => $this->requestParams['links']['BackLink'],
            'FailureBackLink' => $this->requestParams['links']['FailureBackLink'],
            'PostLink' => $this->requestParams['links']['PostLink'],
            'FailurePostLink' => $this->requestParams['links']['FailurePostLink'],
        ];
    }
}