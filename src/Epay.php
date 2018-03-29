<?php

namespace Epay;


use Epay\Requests\RequestFactory;
use Epay\Responses\ResponseFactory;
use Epay\SSL\CertManager;

class Epay
{
    protected $params;

    protected $signer;

    public function __construct($params = [])
    {
        $this->params = $params;

        $this->certManager = new CertManager($params);
    }

    public function buildRequest(string $type, array $params): Requests\AbstractRequest
    {
        return RequestFactory::create($type, array_merge($params, $this->params), $this->certManager);
    }

    public function parseResponse(string $type, string $body)
    {
        return ResponseFactory::create($type, $body, $this->certManager);
    }
}