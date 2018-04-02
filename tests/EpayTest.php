<?php

use KkbEpay\Epay;

class EpayTest extends \PHPUnit\Framework\TestCase
{
    public function testInitializeEpay()
    {
        $epay = new Epay(parse_ini_file('test-certs/config.ini'));

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
            'order_id' => 1234,
            'amount' => 1000,
            'currency' => 398
        ]);

        $this->assertEquals('PGRvY3VtZW50PjxtZXJjaGFudCBjZXJ0X2lkPSIwMGMxODNkNzBiIiBuYW1lPSJUZXN0IHNob3AgMyI+PG9yZGVyIG9yZGVyX2lkPSIwMDEyMzQiIGFtb3VudD0iMTAwMCIgY3VycmVuY3k9IjM5OCI+PGRlcGFydG1lbnQgbWVyY2hhbnRfaWQ9IjkyMDYxMTAzIiBhbW91bnQ9IjEwMDAiLz48L29yZGVyPjwvbWVyY2hhbnQ+PG1lcmNoYW50X3NpZ24gdHlwZT0iUlNBIiBjZXJ0X2lkPSIwMGMxODNkNzBiIj5aSmJLbmNDOFJZZW1vUFJwV1lOT3Q5bnpydXZ0cXFNRlFUcGhyU1RJM0VJdFJvalE0ZGZZa3NJV2hZUUFZWVplMWh5b01MN2l1ZmRkYks4WWswclBUdlpjSmdPeWRidzV0TzJmZWxzM2ZZaEFtTzZNOVpUTnJlcTZpWGhscmJRS01zMDVRdGlMZjN4TUZtOXhmclBtMndTbE1GK096M2tnRk84R0lBYkM3Rnc9PC9tZXJjaGFudF9zaWduPjwvZG9jdW1lbnQ+Cg==', $request);
    }

    /**
     * @depends testInitializeEpay
     * @param \KkbEpay\Epay $epay
     */
    public function testBuildStatusRequest(Epay $epay)
    {
        $request = $epay->buildRequest('status', [
            'order_id' => 1234
        ]);

        $this->assertEquals('<document><merchant id="92061103"><order id="001234"/></merchant><merchant_sign type="RSA" cert_id="00c183d70b">R7cpMWp/P7EIUmWZWDVmhPRYbNUDD2to5SjO7dgEBFQKWhbQYz2+XtqEvGahOQK612WDyTu4rYDktoffDBa8exTAcjKAzslvpVGSr5NlzJn7sO3DjuXmhFkQA4vK7hSv7P2wsZt2f1dZon3qxokFgAYU1fDa8uh8VRkH3k62A1Y=</merchant_sign></document>', $request);
    }

    /**
     * @depends testInitializeEpay
     * @param \KkbEpay\Epay $epay
     */
    public function testParseStatusResponse(Epay $epay)
    {

    }
}