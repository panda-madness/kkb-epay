<?php

namespace Epay\Requests;


use Epay\SSL\CertManager;

class RequestFactory
{
    /**
     * @param string $type
     * @param array $params
     * @return \Epay\Requests\RequestInterface
     */
    public static function create(string $type, array $params, CertManager $signer) : RequestInterface {
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