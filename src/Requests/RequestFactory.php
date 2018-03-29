<?php

namespace Epay\Requests;


use Epay\SSL\CertManager;

class RequestFactory
{
    /**
     * @param string $type
     * @param array $params
     * @param \Epay\SSL\CertManager $signer
     * @return \Epay\Requests\AbstractRequest
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