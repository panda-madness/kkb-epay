<?php

namespace KkbEpay\Requests;


use KkbEpay\SSL\CertManager;

abstract class AbstractRequest
{
    /** @var array $params */
    protected $params;

    /** @var \SimpleXMLElement $xml */
    protected $xml;

    /**
     * @var \KkbEpay\SSL\CertManager $certManager
     */
    protected $certManager;

    public function __construct(array $params, CertManager $certManager)
    {
        $this->params = $params;
        $this->certManager = $certManager;
        $this->xml = $this->buildXML();
    }

    public function getXML() {
        $this->signXML();
        return preg_replace('/^.+\n/', '', $this->xml->saveXML());
    }

    private function signXML()
    {
        $merchant = $this->xml->xpath('/document/merchant')[0];

        $merchantSign = $this->xml->addChild('merchant_sign', $this->certManager->sign($merchant->saveXML()));

        $merchantSign->addAttribute('type', 'RSA');
        $merchantSign->addAttribute('cert_id', $this->params['certificate_id']);
    }

    abstract public function buildXML();
}