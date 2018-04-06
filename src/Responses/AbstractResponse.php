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
    protected $bankSignPath = '';

    public function __construct(string $body, CertManager $certManager)
    {
        $this->xml = new \SimpleXMLElement($body);
        $this->certManager = $certManager;

        $this->props = $this->parse($this->xml);
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
        $data = strrev(
            (string)$this->xml->bank_sign
        );

        $signature = sha1($this->xml->bank->saveXML());

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