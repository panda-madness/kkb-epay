<?php

namespace KkbEpay\Responses;


use KkbEpay\Requests\PaymentRequest;
use KkbEpay\Responses\StatusResponse;
use KkbEpay\SSL\CertManager;

class ResponseFactory
{
    /**
     * @param string $type
     * @param $body
     * @param \KkbEpay\SSL\CertManager $certManager
     * @return \KkbEpay\Responses\AbstractResponse
     */
    public static function create(string $type, $body, CertManager $certManager) : AbstractResponse {
        $request = false;

        switch ($type) {
            case 'payment':
                $request = new PaymentResponse($body, $certManager);
                break;
            case 'status':
                $request = new StatusResponse($body, $certManager);
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