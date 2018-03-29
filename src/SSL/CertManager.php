<?php

namespace KkbEpay\SSL;


class CertManager
{
    protected $publicKeyPath;
    protected $privateKeyPath;
    protected $privateKeyPassword;

    public function __construct(array $params)
    {
        $this->publicKeyPath = $params['pub_key_path'];
        $this->privateKeyPath = $params['priv_key_path'];
        $this->privateKeyPassword = $params['priv_key_pass'] ?? false;
    }

    public function sign($data)
    {
        $privateKey = $this->loadPrivateKey();

        $result = '';

        openssl_sign($data, $result, $privateKey);

        return base64_encode(strrev($result));
    }

    public function verify($data, $signature)
    {
        $publicKey = $this->loadPublicKey();

        return openssl_verify($data, $signature, $publicKey);
    }

    private function loadPrivateKey() {
        if(!$this->privateKeyPassword) {
            return file_get_contents($this->privateKeyPath);
        }

        $privateKey = openssl_pkey_get_private(file_get_contents($this->privateKeyPath), $this->privateKeyPassword);

        if (!\is_resource($privateKey)) {
            return false;
        }

        return $privateKey;
    }

    private function loadPublicKey() {
        return openssl_pkey_get_public(
            file_get_contents($this->publicKeyPath)
        );
    }
}