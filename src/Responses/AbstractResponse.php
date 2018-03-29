<?php

namespace Epay\Responses;


use Epay\SSL\CertManager;

abstract class AbstractResponse
{
    /** @var \Epay\SSL\CertManager $certManager */
    protected $certManager;

    /** @var \SimpleXMLElement $xml */
    protected $xml;

    /** @var array $props */
    protected $props = [];

    protected $merchantPath = '';
    protected $merchantSignPath = '';

    public function __construct(string $body, CertManager $certManager)
    {
        $this->xml = new \SimpleXMLElement($body);
        $this->certManager = $certManager;

        $this->props = $this->fillProps($this->xml);
    }

    public function verify()
    {
        $signature = strrev(
            base64_decode((string)$this->xml->xpath($this->merchantSignPath)[0])
        );

        $data = $this->xml->xpath($this->merchantPath)[0]->saveXML();

        return $this->certManager->verify($data, $signature);
    }

    abstract protected function fillProps(\SimpleXMLElement $sxi);

    public function getProps()
    {
        return $this->props;
    }
}