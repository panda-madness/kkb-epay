<?php

namespace KkbEpay\Requests;


use KkbEpay\SSL\CertManager;

class RequestFactory
{
    /**
     * @param string $type
     * @param array $params
     * @param \KkbEpay\SSL\CertManager $signer
     * @return \KkbEpay\Requests\AbstractRequest
     */
    public static function create(string $type, array $params, CertManager $signer) : AbstractRequest {
        $request = false;

        switch ($type) {
            case 'payment':
                $request = new PaymentRequest($params, $signer);
                break;
            case 'status':
                $request = new StatusRequest($params, $signer);
                break;
            case 'remote':
                break;
            default:
                throw new \InvalidArgumentException('No such request type');
                break;
        }

        return $request;
    }
}