<?php

use KkbEpay\Requests\AbstractRequest;

class AbstractRequestTest extends \PHPUnit\Framework\TestCase
{
    protected $data;

    public function __construct()
    {
        parent::__construct();

        $this->data = include __DIR__ . '/../data.php';
    }


    public function testCreateRequest()
    {
        $certManager = $this->getMockBuilder(\KkbEpay\SSL\CertManager::class)
            ->setConstructorArgs([$this->data['config']])
            ->getMock();

        $request = $this->getMockBuilder(AbstractRequest::class)
            ->setConstructorArgs([[], [], $certManager])
            ->getMockForAbstractClass()
        ;

        $this->assertInstanceOf(AbstractRequest::class, $request);

        return $request;
    }
}