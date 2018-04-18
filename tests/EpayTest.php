<?php

use KkbEpay\Epay;

class EpayTest extends \PHPUnit\Framework\TestCase
{
    protected $data;

    public function __construct()
    {
        parent::__construct();

        $this->data = include 'data.php';
    }

    public function testInitializeEpay()
    {
        $epay = new Epay($this->data['config']);

        $this->assertInstanceOf(Epay::class, $epay);

        return $epay;
    }

    /**
     * @depends testInitializeEpay
     * @param \KkbEpay\Epay $epay
     */
    public function testBuildPaymentRequest(Epay $epay)
    {
        $request = $epay->buildRequest('payment', [
            'order_id' => 64085,
            'amount' => 1000,
            'currency' => 398,
            'links' => [
                'BackLink' => 'http://random-url.com/back',
                'FailureBackLink' => 'http://random-url.com/back_fail',
                'PostLink' => 'http://random-url.com/post',
                'FailurePostLink' => 'http://random-url.com/post_fail',
            ]
        ]);

        $this->assertInstanceOf(\KkbEpay\Requests\PaymentRequest::class, $request);

        $contents = $request->getContents();

        $this->assertArrayHasKey('Signed_Order_B64', $contents);
        $this->assertArrayHasKey('BackLink', $contents);
        $this->assertArrayHasKey('FailureBackLink', $contents);
        $this->assertArrayHasKey('PostLink', $contents);
        $this->assertArrayHasKey('FailurePostLink', $contents);
    }

    /**
     * @depends testInitializeEpay
     * @param \KkbEpay\Epay $epay
     */
    public function testBuildStatusRequest(Epay $epay)
    {
        $request = $epay->buildRequest('status', [
            'order_id' => 64085
        ]);

        $this->assertInstanceOf(\KkbEpay\Requests\StatusRequest::class, $request);
        $this->assertEquals($this->data['status']['request'], $request->getContents());
    }

    /**
     * @depends testInitializeEpay
     * @param \KkbEpay\Epay $epay
     */
    public function testParseStatusResponse(Epay $epay)
    {
        $response = $epay->parseResponse('status', $this->data['status']['response']);

        $contents = $response->get();

        $this->assertInstanceOf(\KkbEpay\Responses\StatusResponse::class, $response);
        $this->assertTrue($response->verify());

        $this->assertArrayHasKey('response', $contents);
        $this->assertArrayHasKey('payment', $contents['response']);
        $this->assertArrayHasKey('status', $contents['response']);
        $this->assertArrayHasKey('result', $contents['response']);

        $this->assertArrayHasKey('order', $contents);
        $this->assertArrayHasKey('id', $contents['order']);
    }

    /**
     * @depends testInitializeEpay
     * @param \KkbEpay\Epay $epay
     */
    public function testParsePaymentResponse(Epay $epay)
    {
        $response = $epay->parseResponse('payment', $this->data['payment']['response']);

        $this->assertInstanceOf(\KkbEpay\Responses\PaymentResponse::class, $response);
        $this->assertTrue($response->verify());

        $contents = $response->get();

        $this->assertArrayHasKey('result', $contents);
        $this->assertArrayHasKey('payment', $contents);
        $this->assertArrayHasKey('order', $contents);
    }
}