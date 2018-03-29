<?php

namespace Epay\Responses;


use Epay\Requests\PaymentRequest;
use Epay\Responses\StatusResponse;
use Epay\SSL\CertManager;

class ResponseFactory
{
    /**
     * @param string $type
     * @param $body
     * @param \Epay\SSL\CertManager $signer
     * @return \Epay\Responses\AbstractResponse
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