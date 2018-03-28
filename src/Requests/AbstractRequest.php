<?php

namespace Epay\Requests;


use Epay\SSL\CertManager;

abstract class AbstractRequest
{
    protected $params;

    /**
     * @var \Epay\SSL\CertManager $certManager
     */
    protected $certManager;

    public function __construct(array $params, CertManager $certManager)
    {
        $this->params = $params;
        $this->certManager = $certManager;
    }

    protected function formatAndSignXml(\SimpleXMLElement $document, bool $appendCertId = false)
    {
        $merchant = $document->xpath('/document/merchant')[0];
        $merchantSign = $document->addChild('merchant_sign', $this->certManager->sign($merchant->saveXML()));
        $merchantSign->addAttribute('type', 'RSA');

        if($appendCertId) {
            $merchantSign->addAttribute('cert_id', $this->params['certificate_id']);
        }

        return preg_replace('/^.+\n/', '', $document->saveXML());
    }
}