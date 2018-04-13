<?php

namespace KkbEpay;


use KkbEpay\Requests\RequestFactory;
use KkbEpay\Responses\ResponseFactory;
use KkbEpay\SSL\CertManager;

class Epay
{
    protected $options;

    protected $certManager;

    public function __construct(array $options = [])
    {
        $this->options = $options;

        $this->certManager = new CertManager($options);
    }

    public function buildRequest(string $type, array $requestParams)
    {
        return RequestFactory::create($type, $this->options, $requestParams, $this->certManager);
    }

    public function parseResponse(string $type, string $body)
    {
        return ResponseFactory::create($type, $body, $this->certManager);
    }

    public function getConfig()
    {
        return $this->params;
    }
}