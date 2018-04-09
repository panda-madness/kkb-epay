<?php

namespace KkbEpay\SSL;


class CertManager
{
    protected $publicKeyPath;
    protected $privateKeyPath;
    protected $privateKeyPassword;
    protected $bankPublicKeyPath;

    public function __construct(array $params)
    {
        $this->publicKeyPath = $params['PUBLIC_KEY_FN'];
        $this->privateKeyPath = $params['PRIVATE_KEY_FN'];
        $this->privateKeyPassword = $params['PRIVATE_KEY_PASS'] ?? false;
        $this->bankPublicKeyPath = $params['BANK_PUBLIC_KEY_FN'];
    }

    public function sign($data)
    {
        $privateKey = $this->loadPrivateKey();

        $result = '';

        openssl_sign($data, $result, $privateKey);

        return $result;
    }

    public function verify($data, $signature, $bank = false)
    {
        $publicKey = $bank ? $this->loadBankPublicKey() : $this->loadPublicKey();

        return (bool)openssl_verify($data, $signature, $publicKey);
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
        return openssl_get_publickey(
            file_get_contents($this->publicKeyPath)
        );
    }

    private function loadBankPublicKey() {
        return openssl_get_publickey(
            file_get_contents($this->bankPublicKeyPath)
        );
    }
}