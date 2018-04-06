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
        $merchantSign->addAttribute('cert_id', $this->params['MERCHANT_CERTIFICATE_ID']);
    }

    abstract public function buildXML();
}