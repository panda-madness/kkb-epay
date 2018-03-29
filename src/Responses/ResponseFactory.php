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
     * @param \KkbEpay\SSL\CertManager $signer
     * @return \KkbEpay\Responses\AbstractResponse
     */
    public static function create(string $type, $body, CertManager $signer) : AbstractResponse {
        $request = false;

        switch ($type) {
            case 'payment':
                $request = new PaymentResponse($body, $signer);
                break;
            case 'status':
                $request = new StatusResponse($body, $signer);
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