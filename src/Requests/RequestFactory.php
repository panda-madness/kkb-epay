<?php

namespace KkbEpay\Requests;


use KkbEpay\SSL\CertManager;

class RequestFactory
{
    /**
     * @param string $type
     * @param array $clientOptions
     * @param array $requestParams
     * @param \KkbEpay\SSL\CertManager $certManager
     * @return \KkbEpay\Requests\AbstractRequest
     */
    public static function create(string $type, array $clientOptions, array $requestParams, CertManager $certManager): AbstractRequest {
        $request = false;

        switch ($type) {
            case 'payment':
                $request = new PaymentRequest($clientOptions, $requestParams, $certManager);
                break;
            case 'status':
                $request = new StatusRequest($clientOptions, $requestParams, $certManager);
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