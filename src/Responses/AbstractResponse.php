<?php

namespace KkbEpay\Responses;


use KkbEpay\SSL\CertManager;

abstract class AbstractResponse
{
    /** @var \KkbEpay\SSL\CertManager $certManager */
    protected $certManager;

    /** @var \SimpleXMLElement $xml */
    protected $xml;

    /** @var array $props */
    protected $props = [];

    /** @var string $merchantPath */
    protected $merchantPath = '';

    /** @var string $merchantSignPath */
    protected $merchantSignPath = '';

    public function __construct(string $body, CertManager $certManager)
    {
        $this->xml = new \SimpleXMLElement($body);
        $this->certManager = $certManager;

        $this->props = $this->fillProps($this->xml);
    }

    /**
     * @param \SimpleXMLElement $xml
     * @return mixed
     */
    abstract protected function parse(\SimpleXMLElement $xml);

    /**
     * @return int
     */
    public function verify()
    {
        $signature = strrev(
            base64_decode((string)$this->xml->xpath($this->merchantSignPath)[0])
        );

        $data = $this->xml->xpath($this->merchantPath)[0]->saveXML();

        return $this->certManager->verify($data, $signature);
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->props;
    }
}