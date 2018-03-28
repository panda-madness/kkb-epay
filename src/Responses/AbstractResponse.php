<?php

namespace Epay\Responses;


use Epay\SSL\CertManager;

abstract class AbstractResponse
{
    protected $certManager;

    protected $xml;

    private $properties = [];

    public function __construct(string $body, CertManager $certManager)
    {
        $this->xml = new \SimpleXMLElement($body);
        $this->certManager = $certManager;

        $signature = strrev(
            base64_decode((string)$this->xml->xpath('/document/bank/merchant_sign')[0])
        );

        $data = $this->xml->xpath('/document/bank/merchant')[0]->saveXML();

        $res = $this->certManager->verify($data, $signature);
    }

    public function __get($name)
    {
        if(array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        throw new \InvalidArgumentException('No such property on this response');
    }

    public function __set($name, $value)
    {
        $this->properties[$name] = $value;

        return null;
    }

    public function __isset($name)
    {
        return isset($this->properties[$name]);
    }

    private function verify($data, $signature)
    {
        return $this->certManager->verify($data, $signature);
    }
}