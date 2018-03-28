<?php

namespace Epay\Responses;


use Epay\SSL\CertManager;

class ResponseFactory
{
    public static function create(string $type, string $body, CertManager $certManager)
    {
        $request = false;
        switch ($type) {
            case 'payment':
                break;
            case 'status':
                $request = new StatusResponse($body, $certManager);
                break;
            case 'remote':
                break;
            default:
                throw new \InvalidArgumentException('No such response type');
                break;
        }

        return $request;
    }
}