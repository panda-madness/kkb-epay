<?php

namespace KkbEpay\Requests;


use KkbEpay\SSL\CertManager;

abstract class AbstractRequest
{
    /** @var array $clientOptions */
    protected $clientOptions;

    /** @var array $requestParams */
    protected $requestParams;

    /** @var \SimpleXMLElement $xml */
    protected $xml;

    /**
     * @var \KkbEpay\SSL\CertManager $certManager
     */
    protected $certManager;

    public function __construct($clientOptions, $requestParams, CertManager $certManager)
    {
        $this->certManager = $certManager;
        $this->clientOptions = $clientOptions;
        $this->requestParams = $requestParams;
        $this->xml = $this->buildXML();
    }

    protected function getXML() {
        $this->signXML();
        return trim(
            preg_replace('/^.+\n/', '', $this->xml->saveXML())
        );
    }

    protected function signXML()
    {
        $merchant = $this->xml->xpath('/document/merchant')[0];

        $signature = base64_encode(
            strrev(
                $this->certManager->sign($merchant->saveXML())
            )
        );

        $merchantSign = $this->xml->addChild('merchant_sign', $signature);

        $merchantSign->addAttribute('type', 'RSA');
        $merchantSign->addAttribute('cert_id', $this->clientOptions['MERCHANT_CERTIFICATE_ID']);
    }

    abstract protected function buildXML();

    abstract public function getContents();
}